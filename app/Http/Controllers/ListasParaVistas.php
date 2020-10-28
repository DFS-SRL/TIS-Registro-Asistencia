<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UsuarioTieneRol;

class ListasParaVistas extends Controller
{
    //
    public function obtenerDocentes(){
        $docentes = UsuarioTieneRol::where('rol_id','=',3)->get()->paginate(10);
        return view('provicional.docentes',[
            'docentes' => $docentes
        ]);
    }

}
