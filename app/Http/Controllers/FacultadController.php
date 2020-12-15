<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facultad;
use App\Unidad;
class FacultadController extends Controller
{
    //
    //Obtener lista de todas las facultades que estan registradas paginadas en 10
    public function listaFacultades(){
        $facultades = Facultad::orderBy('nombre')->paginate(10);
        return view('informacion.listaFacultades',['facultades'=>$facultades]);
    }
    //Obtener la lista de departamentos pertenecientes a una facultad 
    public function listaDepartamentos(Facultad $facultad){
        $departamentos = Unidad::where('facultad_id','=',$facultad->id)->orderBy('nombre')->paginate(5);
        // return $departamentos;
        //Agregar lista de ultimos partes mensuales por departamento
        return view('informacion.listaDepartamentosFac',
                [
                    'departamentos'=>$departamentos,
                    'facultad'=>$facultad
                ]);
    }
}
