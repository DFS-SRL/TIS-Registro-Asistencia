<?php

namespace App\Http\Controllers\ProvController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Menu extends Controller
{
    //Para cada tipo de usuario 
    //se deben mostrar sus nombres completos
    //en un enlace

    public function docentes(){
        return view('provicional.docentes');
    }
    public function auxiliares(){
        return view('provicional.auxiliares');
    }
    public function jefesDept(){
        return view('provicional.jefesDept');
    }
    public function encargadosAsist(){
        return view('provicional.encargadosAsist');
    }
}
