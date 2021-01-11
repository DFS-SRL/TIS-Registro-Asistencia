<?php

namespace App\Http\Controllers;

use App\Planilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PlanillaRequest;

class PlanillaController extends Controller
{
    // Guardar una planilla
    public function guardar(PlanillaRequest $request)
    {
        // verificar permisos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('guardar planilla');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        // validar
        $planillas = array_values($request->validated()['asistencias']);

        foreach ($planillas as $planilla) {
            // reemplazando la anterior planilla
            $antigua = Planilla::find($planilla['horario_clase_id']);
            if ($antigua != null)
                $antigua->delete();
            Planilla::create($planilla);
        }

        return redirect('/')->with('success', "Planilla guardada.");
    }
}