<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Facultad;
use App\Asistencia;
use App\ParteMensual;
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
        $ultimosPartes = ParteMensual::where('unidad_id','=',$unidad->id)
                                      ->orderBy('fecha_ini','desc')->limit(5)->get();

        $ultimosPartes = FechasPartesMensualesHelper::añadirMesPartes($ultimosPartes);
        return view('informacion.departamento', ['unidad' => $unidad, 'ultimosPartes'=>$ultimosPartes]);
    }
}
