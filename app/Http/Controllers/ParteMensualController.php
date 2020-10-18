<?php

namespace App\Http\Controllers;

use App\Rol;
use App\Unidad;
use Carbon\Carbon;
use App\Asistencia;
use Illuminate\Http\Request;
use App\Helpers\AsistenciaHelper;
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
        return AsistenciaHelper::obtenerAsistencias($unidad, 1, $fechaInicio, $fechaFin);
    }

}