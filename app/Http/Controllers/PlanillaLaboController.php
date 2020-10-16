<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use App\HorarioClase;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrarAsistenciaLaboRequest;

class PlanillaLaboController extends Controller
{
    public function obtenerPlanillaDia(Usuario $user)
    {
        // obteniendo horarios asignados en el dia actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $user->codSis)
                                    ->where('rol_id', '=', 1)
                                    ->where('dia', '=', getDia())->get();
        
        // devolver vista de planillas diarias
        return view('planillas.diaria', [
            'fecha' => getFecha(),
            'horarios' => $horarios
        ]);
    }

    public function obtenerInformeSemanal(Unidad $unidad, $fecha)
    {
        // obteniendo las fechas de la semana
        $fechas = getFechasDeSemanaEnFecha($fecha);

        // obteniendo asistencias correspondientes a fechas
        $asistencias = Asistencia::where('fecha', '>=', $fechas[0])
                                ->where('fecha', '<=', $fechas[5])->get();
                                
        // ordenar asistencias segun los criterios establecidos
        $asistencias = $asistencias->sort(function($a, $b) {
            $res;
            if($a->materia->nombre == $b->materia->nombre)
            {
                if($a->usuario->nombre == $b->usuario->nombre)
                    $res = strtotime($a->fecha) < strtotime($b->fecha) ? -1 : 1;
                else
                    $res = $a->usuario->nombre < $b->usuario->nombre ? -1 : 1;
            }
            else
                $res = $a->materia->nombre < $b->materia->nombre ? -1 : 1;
            return $res;
        })->values();
        
        //devolver la vista de informe semanal de laboratorio
        return view('informes.semanalLabo', [
            'asistencias' => $asistencias,
            'fechaInicio' => formatoFecha($fechas[0]),
            'fechaFinal' => formatoFecha($fechas[5]),
            'unidad' => $unidad
        ]);
    }

    public function registrarAsistencia(RegistrarAsistenciaLaboRequest $request)
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