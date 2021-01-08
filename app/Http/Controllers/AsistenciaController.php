<?php

namespace App\Http\Controllers;

use App\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ActualizarAsistenciaRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;

class AsistenciaController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    // actualiza en la base de datos la asistencia otorgada
    public function actualizar(Asistencia $asistencia, ActualizarAsistenciaRequest $request)
    {
        $datosNuevos = $request->validated();

        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar asistencia');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        if ($asistencia->horarioClase->rol_id == 2 && $datosNuevos['asistencia'] == 'true')
            $datosNuevos = Validator::make($datosNuevos, [
                'actividad_realizada' => 'required',
                'indicador_verificable' => 'required',
                'observaciones' => 'nullable',
                'asistencia' => 'required'
            ])->validate();
        if ($datosNuevos['asistencia'] == 'true') {
            if ($asistencia->documento_adicional != null || $asistencia->documento_adicional != '')
                Storage::delete('/documentosAdicionales/' . $asistencia->documento_adicional);
            $datosNuevos['documento_adicional'] = null;
            $datosNuevos['permiso'] = null;
            if (!array_key_exists('observaciones', $datosNuevos))
                $datosNuevos['observaciones'] = null;
            if (!array_key_exists('indicador_verificable', $datosNuevos))
                $datosNuevos['indicador_verificable'] = null;
        } else {
            if (!array_key_exists('permiso', $datosNuevos) || $datosNuevos['permiso'] == null || $datosNuevos['permiso'] == '') {
                Storage::delete('/documentosAdicionales/' . $asistencia->documento_adicional);
                $datosNuevos['documento_adicional'] = null;
            } else if (array_key_exists('documento_adicional', $datosNuevos)) {
                Storage::delete('/documentosAdicionales/' . $asistencia->documento_adicional);
                $doc = $datosNuevos['documento_adicional'];
                $docNombre = pathInfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                $docExtension = $doc->getClientOriginalExtension();
                $nombreAGuardar = $docNombre . '_' . time() . '.' . $docExtension;
                $path = $doc->storeAs('documentosAdicionales', $nombreAGuardar);
                $datosNuevos['documento_adicional'] = $nombreAGuardar;
            }
            $datosNuevos['actividad_realizada'] = null;
            if (!array_key_exists('observaciones', $datosNuevos))
                $datosNuevos['observaciones'] = null;
            $datosNuevos['indicador_verificable'] = null;
        }
        if ($asistencia->nivel == 1)
            $datosNuevos['nivel'] = 2;
        $asistencia->update($datosNuevos);
        return back()->with('success', 'Asistencia actualizada correctamente');
    }

    // dar permiso de edicion de la asistencia al personal academico
    public function permisoEdicion(Asistencia $asistencia)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('otorgar permiso de edicion de asistencia');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        if ($asistencia->nivel != 2)
            throw ValidationException::withMessages([
                'nivel' => ['No se puede otorgar permiso']
            ]);
        $asistencia->update([
            'nivel' => 1
        ]);
        return back()->with('success', 'Permiso de edicion otorgado');
    }

    // invalida la asistencia
    public function invalidar(Asistencia $asistencia)
    {
        if ($asistencia->documento_adicional != null)
            Storage::delete('/documentosAdicionales/' . $asistencia->documento_adicional);
        $asistencia->update([
            'actividad_realizada' => null,
            'indicador_verificable' => null,
            'observaciones' => null,
            'asistencia' => false,
            'permiso' => null,
            'documento_adicional' => null
        ]);
        return back()->with('success', 'Asistencia invalidada.');
    }
}