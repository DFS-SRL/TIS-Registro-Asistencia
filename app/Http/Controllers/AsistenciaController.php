<?php

namespace App\Http\Controllers;

use App\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ActualizarAsistenciaRequest;

class AsistenciaController extends Controller
{
    // actualiza en la base de datos la asistencia otorgada
    public function actualizar(Asistencia $asistencia, ActualizarAsistenciaRequest $request)
    {
        $datosNuevos = $request->validated();
        if ($asistencia->horarioClase->rol_id == 2 && $datosNuevos['asistencia'] == 'true')
            $datosNuevos = Validator::make($datosNuevos, [
                'actividad_realizada' => 'required',
                'indicador_verificable' => 'required',
                'observaciones' => 'nullable',
                'asistencia' => 'required'
            ])->validate();
        $asistencia->update($datosNuevos);
        return $datosNuevos;
    }
}