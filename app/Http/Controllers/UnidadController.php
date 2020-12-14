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
    public function informacionDepartamento(Unidad $unidad){
        return view('informacion.departamento', ['unidad' => $unidad]);
    }
    public function listaFacultades(){
        $facultades = Facultad::orderBy('nombre')->paginate(10);
        return view('informacion.listaFacultades',['facultades'=>$facultades]);
    }
    public function listaDepartamentos(Facultad $facultad){
        $departamentos = Unidad::where('facultad_id','=',$facultad->id)->orderBy('nombre')->paginate(5);
        // return $departamentos;
        return view('informacion.listaDepartamentos',
                [
                    'departamentos'=>$departamentos,
                    'facultad'=>$facultad
                ]);
    }
}
