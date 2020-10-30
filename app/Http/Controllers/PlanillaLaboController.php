<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use App\HorarioClase;
use Illuminate\Http\Request;
use App\helpers\AsistenciaHelper;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegistrarAsistenciaLaboRequest;

class PlanillaLaboController extends Controller
{
    public function obtenerPlanillaDia(Usuario $user)
    {
        // ver si no se lleno la planilla de hoy
        $llenado = $this->hayAsistencias($user);

        // obteniendo horarios asignados en el dia actual
        if (!$llenado)
            $horarios =  HorarioClase::where('asignado_codSis', '=', $user->codSis)
                ->where('rol_id', '=', 1)
                ->where('dia', '=', getDia())->get();
        else
            $horarios = collect(new HorarioClase);
        // devolver vista de planillas diarias
        return view('planillas.diaria', [
            'usuario' => $user,
            'fecha' => getFecha(),
            'horarios' => $horarios,
            'llenado' => $llenado
        ]);
    }

    public function registrarAsistencia(RegistrarAsistenciaLaboRequest $request)
    {
        // validar
        $asistencias = $request->validated()['asistencias'];

        // ver si no se lleno la planilla de hoy
        $llenado = $this->hayAsistencias(Usuario::find(HorarioClase::find($asistencias[0]['horario_clase_id'])->asignado_codSis));
        if ($llenado) {
            $error = ValidationException::withMessages([
                'lleno' => ['LA PLANILLA YA FUE LLENADA']
            ]);
            throw $error;
        }


        // recorrer asistencias colocando datos extra y almacenando en bd
        foreach ($asistencias as $key => $asistencia) {
            $horario = HorarioClase::find($asistencia['horario_clase_id']);
            $asistencia['fecha'] = getFechaF("Y-m-d");
            $asistencia['nivel'] = 2;
            $asistencia['usuario_codSis'] = $horario->asignado_codSis;
            $asistencia['materia_id'] = $horario->materia_id;
            $asistencia['grupo_id'] = $horario->grupo_id;
            $asistencia['unidad_id'] = $horario->unidad_id;
            Asistencia::create($asistencia);
        }

        return "asistencias registradas!!!";
    }

    private function hayAsistencias($usuario)
    {
        $asistencias = Asistencia::where('fecha', '=', date('Y-m-d'))
            ->join('Horario_clase', 'Horario_clase.id', '=', 'horario_clase_id')
            ->where('rol_id', '=', 1)
            ->where('Horario_clase.asignado_codSis', '=', $usuario->codSis)
            ->get();
        return !$asistencias->isEmpty();
    }
}