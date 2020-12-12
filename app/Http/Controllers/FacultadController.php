<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facultad;
class FacultadController extends Controller
{
    //
    public function listaFacultades(){
        $facultades = Facultad::orderBy('nombre')->paginate(10);
        return view('informacion.listaFacultades',['facultades'=>$facultades]);
    }
}
