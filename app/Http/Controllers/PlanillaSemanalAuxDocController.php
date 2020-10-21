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
        $codigoSis = $user->codSis;
        $nombre = Usuario::where('codSis','=',$codigoSis)->value('nombre');

        $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
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
            'codSis' => $codigoSis
        ]);
    }
}
