<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;

class UnidadController extends Controller
{
    //obtener formulario para seleccionar parte mensual del departamento 
    public function obtenerParte(Unidad $unidad)
    {
        return view('parteMensual.seleccion', ['unidad' => $unidad]);
    }
    public function informacionDepartamento(Unidad $unidad){
        return view('informacion.departamento', ['unidad' => $unidad]);
    }
    
}
