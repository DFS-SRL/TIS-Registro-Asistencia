<?php

namespace App\Http\Controllers;

use App\Unidad;
use Illuminate\Http\Request;
use App\helpers\AsistenciaHelper;

class informesSemanalesController extends Controller
{

    // obtener informes semanales de auxiliares de laboratorio
    public function obtenerInformeSemanalDoc(Unidad $unidad, $fecha)
    {
        return $this->obtenerInformeSemanal($unidad, $fecha, 3);
    }

    // obtener informes semanales de auxiliares de docencia
    public function obtenerInformeSemanalAuxDoc(Unidad $unidad, $fecha)
    {
        return $this->obtenerInformeSemanal($unidad, $fecha, 2);
    }

    // obtener informes semanales de auxiliares de laboratorio
    public function obtenerInformeSemanalLabo(Unidad $unidad, $fecha)
    {
        return $this->obtenerInformeSemanal($unidad, $fecha, 1);
    }

    // funcion para obtener informes semanales segun el rol
    private function obtenerInformeSemanal(Unidad $unidad, $fecha, $rol)
    {
        //lista de vistas segun roles
        $vistas = [
            1 => 'semanalLabo',
            2 => 'semanalAuxDoc',
            3 => 'semanalDoc'
        ];

        // obteniendo las fechas de la semana
        $fechas = getFechasDeSemanaEnFecha($fecha);

        // obteniendo asistencias correspondientes a fechas
        $asistencias = AsistenciaHelper::obtenerAsistenciasRol($unidad, $rol, $fechas[0], $fechas[5]);;

        //devolver la vista de informe semanal de laboratorio
        return view('informes.' . $vistas[$rol], [
            'asistencias' => $asistencias,
            'fechaInicio' => formatoFecha($fechas[0]),
            'fechaFinal' => formatoFecha($fechas[5]),
            'unidad' => $unidad
        ]);
    }
}