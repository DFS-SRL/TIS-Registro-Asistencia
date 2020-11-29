<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use Illuminate\Http\Request;
use App\helpers\AsistenciaHelper;
use Illuminate\Validation\ValidationException;

class InformesController extends Controller
{
    // muestra la vista al jefe de departamento para acceder a informes semanales
    public function index(Unidad $unidad)
    {
        return view('informes.index', [
            'unidad' => $unidad
        ]);
    }

    // sube de nivel a las asistencias de los informes
    public function subirInformes()
    {
        calcularFechasMes(request()['fecha'], $t, $fechaInicio, $fechaFin);
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidad(
            Unidad::find(request()['unidad_id']),
            $fechaInicio,
            $fechaFin
        );

        foreach ($asistencias as $key => $asistencia) {
            if ($asistencia->nivel == 1) {
                $error = ValidationException::withMessages([
                    'nivel1' => ['algun docente o auxiliar se encuentra editando sus asistencias']
                ]);
                throw $error;
            }
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

    // subir asistencias sin importar que se habilito edicion al personal
    public function subirInformesFuerza()
    {
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
        return 'enviado correctamente :)';
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
    public function formulario(Unidad $unidad)
    {
        return view('informes.semanales.semanales', ['unidad' => $unidad]);
    }

    // obtener informes semanales de auxiliares de laboratorio
    public function obtenerInformeSemanalDoc(Unidad $unidad, $fecha)
    {
        return $this->obtenerInformeSemanal($unidad, $fecha, 3);
    }

    // obtener informes semanales de auxiliares de docencia
    public function obtenerInformeSemanalAuxDoc(Unidad $unidad, $fecha)
    {
        return $this->obtenerInformeSemanal($unidad, $fecha, 2);
    }

    // obtener informes semanales de auxiliares de laboratorio
    public function obtenerInformeSemanalLabo(Unidad $unidad, $fecha)
    {
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
}