<?php

namespace App\Http\Controllers;

use App\Rol;
use App\Unidad;
use Carbon\Carbon;
use App\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ParteMensualController extends Controller
{
    public function obtenerParteAuxiliares(Unidad $unidad)
    {
        $t = Carbon::now();
        if($t->day <= 15)
            $t->subMonth();
        $t->day = 15;
        $fechaFin = $t->toDateString();
        $t->subMonth();
        $t->addDay();
        $fechaInicio = $t->toDateString();
        return $this->obtenerAsistencias($unidad, 1, $fechaInicio, $fechaFin);
    }

    // devuelve asistencias de la unidad dado rol y fechas
    private function obtenerAsistencias(Unidad $unidad, $rol, $fechaInicio, $fechaFin)
    {
        return DB::table('Asistencia')
                ->where('Asistencia.unidad_id', '=', $unidad->id)
                ->join('Horario_clase', 'horario_clase_id', '=', 'Horario_clase.id')
                ->where('Horario_clase.rol_id', '=', $rol)
                ->where('fecha', '>=', $fechaInicio)
                ->where('fecha',    '<=', $fechaFin)
                ->select('Asistencia.*')
                ->get();
    }
}