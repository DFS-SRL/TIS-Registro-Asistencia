<?php

namespace App\Http\Controllers;

use App\Asistencia;
use Illuminate\Http\Request;
use App\Http\Requests\AsistenciaRequest;

class AsistenciaController extends Controller
{
    // actualiza en la base de datos la asistencia otorgada
    public function actualizar(Asistencia $asistencia, AsistenciaRequest $request)
    {
        //return $asistencia;
        return $request;
    }
}