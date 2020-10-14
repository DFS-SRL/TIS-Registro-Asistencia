<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\HorarioClase;
use Illuminate\Http\Request;

class PlanillaSemanalDocenteController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        // obteniendo horarios asignados en el dia actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $user->codSis)
                                    ->where('rol_id', '=', 3)
                                    ->orderBy('dia', 'ASC') -> get();

        // devolver vista de planillas diarias
        return view('planillas.semanalDocentePrueba', [
            'fechaInicio' => getFecha(), // hard codeado
            'fechaFinal' => getFecha(), // hard codeado
            'horarios' => $horarios
        ]);
    }
}
