<?php

namespace App\Http\Controllers;

use App\HorarioClase;
use Illuminate\Http\Request;

class HorarioClaseController extends Controller
{
    public function eliminar(HorarioClase $horario)
    {
        return "Clase " . $horario->id . " eliminada, es hardcode en realidad no :v";
        return back()->with('status', 'Clase eliminada');
    }
}