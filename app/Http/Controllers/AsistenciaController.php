<?php

namespace App\Http\Controllers;

use App\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
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
        if ($datosNuevos['asistencia'] == 'true' || !array_key_exists('permiso', $datosNuevos) || $datosNuevos['permiso'] == null || $datosNuevos['permiso'] == '') {
            if ($asistencia->documento_adicional != null || $asistencia->documento_adicional != '') {
                Storage::delete('/documentosAdicionales/' . $asistencia->documento_adicional);
                $datosNuevos['documento_adicional'] = null;
            }
        } else
        if (array_key_exists('documento_adicional', $datosNuevos)) {
            Storage::delete('/documentosAdicionales/' . $asistencia->documento_adicional);

            $doc = $datosNuevos['documento_adicional'];
            $docNombre = pathInfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
            $docExtension = $doc->getClientOriginalExtension();
            $nombreAGuardar = $docNombre . '_' . time() . '.' . $docExtension;
            $path = $doc->storeAs('documentosAdicionales', $nombreAGuardar);
            $datosNuevos['documento_adicional'] = $nombreAGuardar;
        }
        if ($asistencia->nivel == 1)
            $datosNuevos['nivel'] = 2;
        $asistencia->update($datosNuevos);
        return back()->with('success', 'Asistencia actualizada correctamente');
    }
}