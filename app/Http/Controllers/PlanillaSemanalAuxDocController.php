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
        $nombre = Usuario::where('codSis','=',$user->codSis)->value('nombre');

        $horarios =  HorarioClase::select('dia','hora_inicio','hora_fin','grupo_id','materia_id','unidad_id')
                                    ->where('asignado_codSis', '=', $user->codSis)
                                    ->where('rol_id', '=', 2)
                                    ->orderBy('dia', 'DESC')
                                    ->orderBy('hora_inicio', 'DESC')
                                    ->get();


        $horarios =$horarios->groupBy('unidad_id');
        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanalAuxDoc', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["VIERNES"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'nombre' => $nombre,
            'codSis' => $user
        ]);
    }
}
