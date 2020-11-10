<?php

namespace App\Http\Controllers;

use App\HorarioClase;
use Illuminate\Http\Request;
use App\Http\Requests\GuardarHorarioRequest;
use Illuminate\Validation\ValidationException;

class HorarioClaseController extends Controller
{
    public function guardar(GuardarHorarioRequest $request)
    {

        $horario = $request->validated();
        if ($horario['hora_inicio'] == ":00") {
            $error = ValidationException::withMessages([
                'horario' => ['debe añadir las horas del nuevo horario para guardar los cambios']
            ]);
            throw $error;
        }
        $this->validarHoras($horario);
        $this->asignarPersonal($horario);
        $horario['activo'] = true;
        HorarioClase::create($horario);
        return back()->with('success', 'Registro existoso');
    }

    // asigna el personal al horario de acuerdo a los horarios del grupo
    private function asignarPersonal(&$horario)
    {
        $horarios = HorarioClase::where('grupo_id', '=', $horario['grupo_id'])
            ->where('rol_id', '=', $horario['rol_id'])
            ->get();
        if (!$horarios->isEmpty() && $horarios[0]->asignado_codSis)
            $horario['asignado_codSis'] = $horarios[0]->asignado_codSis;
    }

    // valida las horas del horario
    private function validarHoras($horario, $except = -1)
    {
        if (!$this->verificarLibre($horario, $except)) {
            $error = ValidationException::withMessages([
                'horario' => ['El horario choca con algún otro horario']
            ]);
            throw $error;
        }
        if (
            $horario['hora_fin'] <= $horario['hora_inicio'] ||
            tiempoHora($horario['hora_inicio'])->diffInMinutes(tiempoHora($horario['hora_fin'])) % 45 != 0
        ) {
            $error = ValidationException::withMessages([
                'horario' => ['las hora fin debe ser mayor a la inicio con periodos de 45 minutos']
            ]);
            throw $error;
        }
    }

    // verifica si un horario no choca con algun otro en el grupo al que pertenece el horario
    private function verificarLibre($horario)
    {
        return HorarioClase::where('grupo_id', '=', $horario['grupo_id'])
            ->where('activo', '=', 'true')
            ->where('dia', '=', $horario['dia'])
            ->where(function ($query) use ($horario) {
                $query->where(function ($query) use ($horario) {
                    $query->where('hora_inicio', '=', $horario['hora_inicio'])
                        ->where('hora_fin', '=', $horario['hora_fin']);
                })->orWhere(function ($query) use ($horario) {
                    $query->where('hora_inicio', '<', $horario['hora_inicio'])
                        ->where('hora_fin', '>', $horario['hora_inicio']);
                })->orWhere(function ($query) use ($horario) {
                    $query->where('hora_inicio', '<', $horario['hora_fin'])
                        ->where('hora_fin', '>', $horario['hora_fin']);
                })->orWhere(function ($query) use ($horario) {
                    $query->where('hora_inicio', '>', $horario['hora_inicio'])
                        ->where('hora_inicio', '<', $horario['hora_fin']);
                })->orWhere(function ($query) use ($horario) {
                    $query->where('hora_fin', '>', $horario['hora_inicio'])
                        ->where('hora_fin', '<', $horario['hora_fin']);
                });
            })
            ->get()
            ->isEmpty();
    }


    // actualiza en la base de datos el horario otorgado
    public function actualizar(HorarioClase $horario, GuardarHorarioRequest $request)
    {
        $horarioNuevo = $request->validated();
        $horarioNuevo['hora_inicio'] .= ":00";
        $horarioNuevo['hora_fin'] .= ":00";
        $horarioNuevo['activo'] = true;
        $this->validarHoras($horarioNuevo);
        $horario->update([
            'activo' => false
        ]);
        HorarioClase::create($horarioNuevo);
        return back()->with('success', 'Clase actualizada');
    }

    // elimina de la base de datos el horario otorgado
    public function eliminar(HorarioClase $horario)
    {
        $horario->update([
            'activo' => false
        ]);
        return back()->with('success', 'Clase eliminada');
    }
}