<?php

namespace App\Http\Controllers;

use App\HorarioClase;
use Illuminate\Http\Request;

class HorarioClaseController extends Controller
{
    public function eliminar(HorarioClase $horario)
    {
        $horario->delete();
        return back()->with('status', 'Clase eliminada');
    }
}