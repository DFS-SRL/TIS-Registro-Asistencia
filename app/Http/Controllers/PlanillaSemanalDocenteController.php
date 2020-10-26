<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\HorarioClase;
use App\Unidad;
use App\Asistencia;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrarAsistenciaDocenteRequest;

class PlanillaSemanalDocenteController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        $codigoSis = $user->codSis;
        $nombre = Usuario::where('codSis','=',$codigoSis)->value('nombre');

        $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
                                    ->where('rol_id', '=', 3)
                                    ->orderBy('dia', 'ASC')
                                    ->get();


        $horarios =$horarios->groupBy('unidad_id');
        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanalDocente', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'nombre' => $nombre,
            'codSis' => $codigoSis
        ]);
    }
}