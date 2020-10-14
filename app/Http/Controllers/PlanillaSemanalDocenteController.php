<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\HorarioClase;
use Illuminate\Http\Request;

class PlanillaSemanalDocenteController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        // obteniendo horarios asignados al docente actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $user->codSis)
                                    ->where('rol_id', '=', 3)
                                    ->orderBy('dia', 'ASC') -> get();


        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanalDocentePrueba', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["VIERNES"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios
        ]);
    }
}
