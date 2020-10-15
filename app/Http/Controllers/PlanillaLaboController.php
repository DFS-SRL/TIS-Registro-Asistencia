<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use App\HorarioClase;
use Illuminate\Http\Request;

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
        $fechas = getFechasDeSemanaEnFecha($fecha);
        $resultado = [];
        //echo $unidad->id . "    ";
        foreach ($fechas as $key => $fecha) {
            //echo $fecha . "   ";
            $resultado = [
                $resultado,
                Asistencia::where('unidad_id', '=', $unidad->id)
                            ->where('fecha', '=', $fecha)->get()
            ];
        }
        return $resultado;
        return call_user_func_array('array_merge', $resultado);
        return getFechasDeSemanaEnFecha($fecha);
    }
}