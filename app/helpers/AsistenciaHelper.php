<?php

namespace App\helpers;

use App\Unidad;
use App\Usuario;
use Carbon\Carbon;
use App\Asistencia;
use Illuminate\Support\Facades\DB;

class AsistenciaHelper {
     // devuelve asistencias de la unidad dado rol y fechas
    public static function obtenerAsistencias(Unidad $unidad, $rol, $fechaInicio, $fechaFin)
    {
        return self::aux($unidad, $rol, $fechaInicio, $fechaFin)->get();
    }

    // devuelve asistencias de la unidad dado rol, fechas de un determinado usuario
    public static function obtenerAsistenciasUsuario(Unidad $unidad, $rol, $fechaInicio, $fechaFin, Usuario $usuario)
    {
        return self::aux($unidad, $rol, $fechaInicio, $fechaFin)
                    ->where('usuario_codSis', '=', $usuario->codSis)->get();
    }

    // funcion auxiliar
    private static function aux(Unidad $unidad, $rol, $fechaInicio, $fechaFin)
    {
        return Asistencia::where('Asistencia.unidad_id', '=', $unidad->id)
                ->where('fecha', '>=', $fechaInicio)
                ->where('fecha',    '<=', $fechaFin)
                ->join('Horario_clase', 'horario_clase_id', '=', 'Horario_clase.id')
                ->where('Horario_clase.rol_id', '=', $rol)
                ->select('Asistencia.*');
    }
}