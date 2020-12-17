<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Facultad;
use App\Asistencia;
use App\Helpers\FechasPartesMensualesHelper;
class UnidadController extends Controller
{
    //obtener formulario para seleccionar parte mensual del departamento 
    public function obtenerParte(Unidad $unidad)
    {
        return view('parteMensual.seleccion', ['unidad' => $unidad]);
    }
    //Obtener informacion de un departamento y la lista de sus ultimos 5 partes mensuales
    public function informacionDepartamento(Unidad $unidad){
        //Agregar lista de ultimos partes mensuales
        $nivel = 3;//Para Facultativo - 4 para DPA
        $fechaParte = FechasPartesMensualesHelper::getFechaUltimoParte();
        //si existe
        $asistenciasParte = Asistencia::where('unidad_id','=',$unidad->id)
                                      ->where('nivel','>=',$nivel)
                                      ->where('fecha', '>=',$fechaParte["fecha"])->get();
        //=> ahi empieza el ultimo parte y  buscar los demas
        // return [$date,$mes];
        // return $asistenciasParte;
        return view('informacion.departamento', ['unidad' => $unidad]);
    }
}
