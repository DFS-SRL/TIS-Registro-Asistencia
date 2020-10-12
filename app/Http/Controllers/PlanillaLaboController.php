<?php

namespace App\Http\Controllers;

use App\Usuario;
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
}