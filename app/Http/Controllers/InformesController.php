<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use App\UsuarioTieneRol;
use App\ParteMensual;
use Illuminate\Http\Request;
use App\helpers\AsistenciaHelper;
use App\HorarioClase;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class InformesController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    // muestra la vista al jefe de departamento para acceder a informes semanales
    public function index(Unidad $unidad)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes semanales')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        $accesoOtorgado |= (Auth::user()->usuario->tienePermisoNombre('enviar asistencias para aprobacion')
            &  Auth::user()->usuario->perteneceAUnidad($unidad->id));
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        return view('informes.index', [
            'unidad' => $unidad
        ]);
    }

    private function registrarParteMensual($unidad_id, $fecha_ini, $fecha_fin)
    {
        $parte = [];
        $parte['fecha_ini'] = $fecha_ini;
        $parte['fecha_fin'] = $fecha_fin;
        $parte['unidad_id'] = $unidad_id;
        ParteMensual::create($parte);
    }

    // sube de nivel a las asistencias de los informes y almacena dentro de la tabla Parte_mensual
    public function subirInformes()
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('enviar asistencias para aprobacion');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        calcularFechasMes(request()['fecha'], $t, $fechaInicio, $fechaFin);
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidad(
            Unidad::find(request()['unidad_id']),
            $fechaInicio,
            $fechaFin
        );

        foreach ($asistencias as $key => $asistencia) {
            if ($asistencia->nivel == 1) {
                $error = ValidationException::withMessages([
                    'nivel1' => ['Algún docente o auxiliar se encuentra editando sus asistencias.']
                ]);
                throw $error;
            }
            if ($asistencia->nivel == 3) {
                $error = ValidationException::withMessages([
                    'nivel3' => ['Las asistencias ya fueron enviadas a decanatura.']
                ]);
                throw $error;
            }
        }
        if (
            ParteMensual::where('fecha_ini', '=', $fechaInicio)
            ->where('fecha_fin', '=', $fechaFin)
            ->where('unidad_id', '=', request()['unidad_id'])
            ->count() == 1
        )
            throw ValidationException::withMessages([
                'nivel3' => ['Las asistencias ya fueron enviadas a decanatura.']
            ]);
        $this->registrarParteMensual(request()['unidad_id'], $fechaInicio, $fechaFin);
        $this->subirNivel($asistencias);
        return back()->with('success', 'Enviado correctamente :)');
    }

    // subir asistencias sin importar que se habilito edicion al personal y almacena dentro de la tabla Parte_mensual
    public function subirInformesFuerza()
    {
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('enviar asistencias para aprobacion');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        calcularFechasMes(request()['fecha'], $t, $fechaInicio, $fechaFin);
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidad(
            Unidad::find(request()['unidad_id']),
            $fechaInicio,
            $fechaFin
        );

        foreach ($asistencias as $key => $asistencia) {
            if ($asistencia->nivel == 3) {
                $error = ValidationException::withMessages([
                    'nivel3' => ['los informes ya fueron enviados a facultativo']
                ]);
                throw $error;
            }
        }
        $this->subirNivel($asistencias);
        return back()->with('success', 'Enviado correctamente :)');
    }

    private function subirNivel($asistencias)
    {
        foreach ($asistencias as $key => $asistencia) {
            $asistencia->update([
                'nivel' => 3,
            ]);
        }
    }

    //obtener formulario para seleccionar informes semanales en el departamento
    public function formularioUnidad(Unidad $unidad)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes semanales')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        return view('informes.semanales.unidadSeleccion', ['unidad' => $unidad]);
    }

    //obtener formulario para seleccionar informes semanales de un miembro del personal academico
    public function formularioUsuario(Usuario $usuario)
    {
        $acceso = Auth::user()->usuario->tienePermisoNombre('ver informes semanales propios')
            & (Auth::user()->usuario->codSis == $usuario->codSis);

        return view('informes.semanales.usuarioSeleccion', ['usuario' => $usuario]);
    }


    // obtener informe semanal de un miembro del personal academico
    public function obtenerInformeSemanalUsuario(Usuario $usuario, $fecha)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes semanales propios')
            & (Auth::user()->usuario->codSis == $usuario->codSis);
        // Solo autoridades de la misma unidad/facultad pueden ver informes semanales del personal
        $accesoOtorgado |= (Auth::user()->usuario->tienePermisoNombre('ver informes semanales')
            & Auth::user()->usuario->mismoDepartamento($usuario));
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        // obteniendo las fechas de la semana
        $fechas = getFechasDeSemanaEnFecha($fecha);

        // obteniendo asistencias correspondientes a fechas
        $asistencias = AsistenciaHelper::obtenerAsistenciasUsuario($usuario, $fechas[0], $fechas[5])
            ->groupBy('unidad_id');

        $esDocente = UsuarioTieneRol::where('usuario_codSis', '=', $usuario->codSis)
            ->where('rol_id', '=', 3)
            ->count() > 0;

        // devolver la vista del informe pasado
        return view('informes.semanales.semanalUsuario', [
            'usuario' => $usuario,
            'asistencias' => $asistencias,
            'fechaInicio' => $fechas[0],
            'fechaFinal' => $fechas[5],
            'esDocente' => $esDocente
        ]);
    }

    // obtener informes semanales de auxiliares de laboratorio
    public function obtenerInformeSemanalDoc(Unidad $unidad, $fecha)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes semanales')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        return $this->obtenerInformeSemanal($unidad, $fecha, 3);
    }

    // obtener informes semanales de auxiliares de docencia
    public function obtenerInformeSemanalAuxDoc(Unidad $unidad, $fecha)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes semanales')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        return $this->obtenerInformeSemanal($unidad, $fecha, 2);
    }

    // obtener informes semanales de auxiliares de laboratorio
    public function obtenerInformeSemanalLabo(Unidad $unidad, $fecha)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes semanales')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        return $this->obtenerInformeSemanal($unidad, $fecha, 1);
    }

    // funcion para obtener informes semanales segun el rol
    private function obtenerInformeSemanal(Unidad $unidad, $fecha, $rol)
    {
        //lista de vistas segun roles
        $vistas = [
            1 => 'semanalLabo',
            2 => 'semanalAuxDoc',
            3 => 'semanalDoc'
        ];

        // obteniendo las fechas de la semana
        $fechas = getFechasDeSemanaEnFecha($fecha);

        // obteniendo asistencias correspondientes a fechas
        $asistencias = AsistenciaHelper::obtenerAsistenciasRol($unidad, $rol, $fechas[0], $fechas[5]);;

        //devolver la vista de informe semanal de laboratorio
        return view('informes.semanales.' . $vistas[$rol], [
            'asistencias' => $asistencias,
            'fechaInicio' => formatoFecha($fechas[0]),
            'fechaFinal' => formatoFecha($fechas[5]),
            'unidad' => $unidad
        ]);
    }

    // obtener informe mensual de asistencia de un docente de la unidad
    public function obtenerInformeMensualDocente(Unidad $unidad, $fecha, Usuario $usuario)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes mensuales')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        if (!PersonalAcademicoController::esDocente($usuario->codSis, $unidad->id)) {
            $error = ValidationException::withMessages([
                'codSis' => ['el codigo sis no pertenece a un docente de la unidad']
            ]);
            throw $error;
        }

        // obtener fechas inicio y fin del mes
        calcularFechasMes($fecha, $t, $fechaInicio, $fechaFinal);

        // obteniendo asistencias correspondientes a fechas
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidadUsuario($unidad, $usuario, $fechaInicio, $fechaFinal)->get();

        // devolver la vista del docente 
        return view('informes.mensuales.mensualDoc', [
            'unidad' => $unidad,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal,
            'gestion' => $t->year,
            'usuario' => $usuario,
            'asistencias' => $asistencias
        ]);
    }

    // obtener informe mensual de asistencia de un auxiliar de la unidad
    public function obtenerInformeMensualAuxiliar(Unidad $unidad, $fecha, Usuario $usuario)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver informes mensuales')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        if (!PersonalAcademicoController::esAuxiliar($usuario->codSis, $unidad->id)) {
            $error = ValidationException::withMessages([
                'codSis' => ['el codigo sis no pertenece a un auxilar de la unidad']
            ]);
            throw $error;
        }

        // obtener fechas inicio y fin del mes
        calcularFechasMes($fecha, $t, $fechaInicio, $fechaFinal);

        // obteniendo asistencias correspondientes a fechas
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidadUsuario($unidad, $usuario, $fechaInicio, $fechaFinal)->get();
        $asistenciasLabo = AsistenciaHelper::obtenerAsistenciasUnidadUsuario($unidad, $usuario, $fechaInicio, $fechaFinal)
            ->where('rol_id', '=', 1)
            ->get();
        $asistenciasDoc = AsistenciaHelper::obtenerAsistenciasUnidadUsuario($unidad, $usuario, $fechaInicio, $fechaFinal)
            ->where('rol_id', '=', 2)
            ->get();

        // devolver la vista del auxiliar
        return view('informes.mensuales.mensualAux', [
            'unidad' => $unidad,
            'fechaInicio' => $fechaInicio,
            'fechaFinal' => $fechaFinal,
            'gestion' => $t->year,
            'usuario' => $usuario,
            'asistencias' => $asistencias,
            'asistenciasLabo' => $asistenciasLabo,
            'asistenciasDoc' => $asistenciasDoc
        ]);
    }

    public function obtenerPlanillaExcepcionAuxiliares(Unidad $unidad, $fecha, Usuario $usuario, Usuario $jefe)
    {
        //Verificamos que se tengan los permisos necesarios
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('llenar planilla de excepcion')
            & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        // obteniendo las fechas de la semana
        $fechas = getFechasDeSemanaEnFecha($fecha);

        $rol = 1;

        // obteniendo asistencias correspondientes a fechas
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidadUsuario($unidad, $usuario, $fechas[0], $fechas[5])->get();

        //devolver la vista de informe semanal de laboratorio
        return view('informes.semanales.excepcionAuxiliar', [
            'asistencias' => $asistencias,
            'fechaInicio' => formatoFecha($fechas[0]),
            'fechaFinal' => formatoFecha($fechas[5]),
            'unidad' => $unidad
        ]);
    }
}