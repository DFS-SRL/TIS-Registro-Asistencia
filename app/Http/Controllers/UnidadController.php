<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Facultad;

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
        return view('informacion.departamento', ['unidad' => $unidad]);
    }
}
