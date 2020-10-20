<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\HorarioClase;
use Illuminate\Http\Request;

class PlanillaSemanalAuxDocController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        // obteniendo horarios asignados al auxiliar actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $user->codSis)
                                    ->where('rol_id', '=', 2)
                                    ->orderBy('dia', 'ASC')
                                    ->orderBy('hora_inicio', 'ASC')
                                    -> get();


        $fechasDeSemana = getFechasDeSemanaActual();

        // echo($horarios);
        // devolver vista de planillas semanales
        return view('planillas.semanalAuxDoc', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["VIERNES"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios
        ]);
    }
}
