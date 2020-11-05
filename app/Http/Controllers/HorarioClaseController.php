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
        $this->validarHoras($horario);
        HorarioClase::create($horario);
        return back()->with('success', 'Registro exitoso');
    }

    // valida las horas del horario
    private function validarHoras($horario)
    {
        if (!$this->verificarLibre($horario)) {
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
    // elimina de la base de datos el horario otorgado
    public function eliminar(HorarioClase $horario)
    {
        $horario->delete();
        return back()->with('success', 'Clase eliminada');
    }
}