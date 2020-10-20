<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\HorarioClase;
use App\Unidad;
use App\Asistencia;
use Illuminate\Http\Request;
use App\helpers\AsistenciaHelper;
use App\Http\Requests\RegistrarAsistenciaDocenteRequest;

class PlanillaSemanalDocenteController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        // Para obtener los horarios separados por departamentos, sacamos una lista
        // de todos los departamentos y luego recorremos la lista sacando todos
        // los horarios que tiene el docente en cada departamento
        
        // El resultado sera un arreglo de arreglos de HorarioClase
        $horariosPorDpto = [];
        $departamentos = Unidad::all();

        foreach ($departamentos as $dpto) {
            $horarios = HorarioClase::where('asignado_codSis', '=', $user->codSis)-> where('rol_id', '=', 3)-> where('unidad_id', '=', $dpto->id)-> orderBy('dia', 'ASC')-> get();
            if (!$horarios->isEmpty())
                array_push($horariosPorDpto, $horarios);
        }

        //return $horariosPorDpto;
        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanalDocente', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["VIERNES"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horariosPorDpto
        ]);
    }
    public function registrarAsistencia(RegistrarAsistenciaDocenteRequest $request)
    {
        // validar
        $asistencias = $request->validated()['asistencias'];

        // recorrer asistencias colocando datos extra y almacenando en bd
        foreach ($asistencias as $key => $asistencia) {
            $horario = HorarioClase::find($asistencia['horario_clase_id']);
            $asistencia['fecha'] = getFechaF("Y-m-d");
            $asistencia['nivel'] = 2;
            $asistencia['usuario_codSis'] = $horario->asignado_codSis;
            $asistencia['materia_id'] = $horario->materia_id;
            $asistencia['grupo_id'] = $horario->grupo_id;
            $asistencia['unidad_id'] = $horario->unidad_id;
            Asistencia::create($asistencia);
        }
        
        return "asistencias registradas!!!";
    }

}