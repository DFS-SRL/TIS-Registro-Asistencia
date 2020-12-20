<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use App\HorarioClase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegistrarAsistenciaDocenteRequest;
use App\Http\Requests\RegistrarAsistenciaSemanalRequest;
use App\User;
use App\UsuarioTieneRol;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;


class PlanillaSemanalController extends Controller{

    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // para obtener la planilla semanal de auxiliar de docencia
    public function obtenerPlanillaSemanalAuxDoc(Usuario $user)
    {
        $rolesPermitidos = [2];
        $acceso = UsuarioTieneRol::alMenosUnRol(auth()->user()->usuario->codSis, $rolesPermitidos) && User::inicioSesion($user);
        if ($acceso){
            return $this->obtenerPlanillaSemanal($user, 2);
        }
        return view('/provicional/noAutorizado');
    }

    // para obtener la planilla semanal de docente
    public function obtenerPlanillaSemanalDocente(Usuario $user)
    {
        $rolesPermitidos = [3];
        $acceso = UsuarioTieneRol::alMenosUnRol(auth()->user()->usuario->codSis, $rolesPermitidos) && User::inicioSesion($user);
        if ($acceso){
            return $this->obtenerPlanillaSemanal($user, 3);
        }
        return view('/provicional/noAutorizado');
    }

    // para obtener la planilla semanal dado un rol
    private function obtenerPlanillaSemanal(Usuario $user, $rol)
    {
        $codigoSis = $user->codSis;

        // obteniendo horarios asignados al auxiliar actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
            ->where('activo', '=', 'true')
            ->where('rol_id', '=', $rol)
            ->orderBy(
                'dia',
                'ASC'
            )
            ->orderBy('hora_inicio', 'ASC')
            ->get();
        // ver si no se lleno la planilla de esta semana
        $registradas = $this->asistenciasRegistradas($user, [$rol]);
        $llenado = $registradas->count() == $horarios->count() && $horarios->count() > 0;

        foreach ($horarios as $key => $horario) {
            if ($registradas->contains('id', $horario->id)) {
                $horarios->forget($key);
            }
        }

        $horarios = $horarios->groupBy('unidad_id');

        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanal' . ($rol == 3 ? 'Docente' : 'AuxDoc'), [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'usuario' => $user,
            'llenado' => $llenado
        ]);
    }

    // para obtener la planilla de excepcion de docente
    public function obtenerPlanillaExcepcionDocente(Unidad $unidad, Usuario $usuario)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        return $this->obtenerPlanillaExcepcion($unidad, $usuario, [3]);
    }

    // para obtener la planilla de excepcion de auxiliar
    public function obtenerPlanillaExcepcionAuxiliar(Unidad $unidad, Usuario $usuario)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        return $this->obtenerPlanillaExcepcion($unidad, $usuario, [1, 2]);
    }

    // obtener planilla semanal de excepcion dado unidad usuario y roles
    private function obtenerPlanillaExcepcion(Unidad $unidad, Usuario $usuario, $roles)
    {
        // obteniendo horarios asignados al auxiliar actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $usuario->codSis)
            ->where('activo', '=', 'true')
            ->whereIn('rol_id', $roles)
            ->where('unidad_id', '=', $unidad->id)
            ->orderBy('dia', 'ASC')
            ->orderBy('hora_inicio', 'ASC')
            ->get();

        // ver si no se lleno la planilla de esta semana
        $registradas = $this->asistenciasRegistradas($usuario, $roles, [$unidad->id]);
        $llenado = $registradas->count() == $horarios->count() && $horarios->count() > 0;

        foreach ($horarios as $key => $horario) {
            if ($registradas->contains('id', $horario->id)) {
                $horarios->forget($key);
            }
        }
        $fechasDeSemana = getFechasDeSemanaActual();

        $horarios = $horarios->groupBy('unidad_id');
        // devolver vista de planilla de excepcion
        return view('planillas.excepcion.' . ($roles[0] == 3 ? 'docente' : 'auxiliar'), [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'usuario' => $usuario,
            'unidad' => $unidad,
            'llenado' => $llenado
        ]);
    }

    // registrar asistencias de la semana
    public function registrarAsistenciasSemana(RegistrarAsistenciaSemanalRequest $request)
    {
        $rolesPermitidos = [2,3];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        // validar
        $asistencias = array_values($request->validated()['asistencias']);

        //ver si no se lleno la planilla de esta semana
        $usuario = Usuario::find(HorarioClase::find($asistencias[0]['horario_clase_id'])->asignado_codSis);
        $roles = [];
        $unidades = [];
        foreach ($asistencias as $asistencia) {
            $horario = HorarioClase::find($asistencia['horario_clase_id']);
            if (!in_array($horario->rol_id, $roles))
                array_push($roles, $horario->rol_id);
            if (!in_array($horario->unidad_id, $unidades))
                array_push($unidades, $horario->unidad_id);
        }
        $registradas = $this->asistenciasRegistradas($usuario, $roles, $unidades);
        if ($registradas->count() == $this->cuantosHorarios($usuario, $roles, $unidades)) {
            $error = ValidationException::withMessages([
                'lleno' => ['LA PLANILLA YA FUE LLENADA']
            ]);
            throw $error;
        }

        // recorrer asistencias colocando datos extra y almacenando en bd
        foreach ($asistencias as $asistencia) {
            if ($registradas->contains('id', $asistencia['horario_clase_id']))
                continue;

            // Se cambia el formato de fecha de d/m/Y a Y-m-d para la BD
            $asistencia['fecha'] = convertirFechaDMYEnYMD($asistencia['fecha']);

            $horario = HorarioClase::find($asistencia['horario_clase_id']);
            $asistencia['nivel'] = 2;
            $asistencia['usuario_codSis'] = $horario->asignado_codSis;
            $asistencia['materia_id'] = $horario->materia_id;
            $asistencia['grupo_id'] = $horario->grupo_id;
            $asistencia['unidad_id'] = $horario->unidad_id;

            if (array_key_exists('documento_adicional', $asistencia)) {
                $doc = $asistencia['documento_adicional'];
                $docNombre = pathInfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                $docExtension = $doc->getClientOriginalExtension();
                $nombreAGuardar = $docNombre . '_' . time() . '.' . $docExtension;
                $path = $doc->storeAs('documentosAdicionales', $nombreAGuardar);
                $asistencia['documento_adicional'] = $nombreAGuardar;
            }

            Asistencia::create($asistencia);
        }

        return back()->with('success', "asistencias registradas!!!");
    }

    // funcion auxiliar para ver si hay asistencias en la semana para no registrar 2 veces asistencias
    private function asistenciasRegistradas($usuario, $roles, $unidades = null)
    {
        $fechas = getFechasDeSemanaEnFecha(date('Y-m-d'));
        $asistencias = Asistencia::where('fecha', '>=', $fechas[0])
            ->where('fecha', '<=', $fechas[5])
            ->join('Horario_clase', 'Horario_clase.id', '=', 'horario_clase_id')
            ->whereIn('rol_id', $roles)
            ->where('Horario_clase.asignado_codSis', '=', $usuario->codSis);
        if ($unidades != null)
            $asistencias = $asistencias->whereIn('Horario_clase.unidad_id', $unidades);
        return $asistencias->select('Horario_clase.id')
            ->get();
    }

    // contar horarios de la semana
    private function cuantosHorarios($usuario, $roles, $unidades)
    {
        return HorarioClase::where('asignado_codSis', '=', $usuario->codSis)
            ->where('activo', '=', 'true')
            ->whereIn('rol_id', $roles)
            ->whereIn('unidad_id', $unidades)
            ->count();
    }
}