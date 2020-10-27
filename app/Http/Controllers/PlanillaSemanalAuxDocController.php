<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\Asistencia;
use App\HorarioClase;
use Illuminate\Http\Request;

class PlanillaSemanalAuxDocController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        $codigoSis = $user->codSis;

        // ver si no se lleno la planilla de esta semana
        $llenado = $this->hayAsistencias($user);

        if (!$llenado) {
            // obteniendo horarios asignados al auxiliar actual
            $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
                ->where('rol_id', '=', 2)
                ->orderBy('dia', 'DESC')
                ->orderBy('hora_inicio', 'DESC')
                ->get();
            $horarios = $horarios->groupBy('unidad_id');
        } else
            $horarios = collect(new HorarioClase);

        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanalAuxDoc', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'nombre' => $user->nombre,
            'codSis' => $codigoSis,
            'llenado' => $llenado
        ]);
    }

    private function hayAsistencias($usuario)
    {
        $fechas = getFechasDeSemanaEnFecha(date('Y-m-d'));
        $asistencias = Asistencia::where('fecha', '>=', $fechas[0])
            ->where('fecha', '<=', $fechas[5])
            ->join('Horario_clase', 'Horario_clase.id', '=', 'horario_clase_id')
            ->where('rol_id', '=', 2)
            ->where('Horario_clase.asignado_codSis', '=', $usuario->codSis)
            ->get();
        return !$asistencias->isEmpty();
    }
}