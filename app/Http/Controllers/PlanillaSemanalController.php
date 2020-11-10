<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use App\HorarioClase;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\RegistrarAsistenciaDocenteRequest;
use App\Http\Requests\RegistrarAsistenciaSemanalRequest;

class PlanillaSemanalController extends Controller
{
    // para obtener la planilla semanal de auxiliar de docencia
    public function obtenerPlanillaSemanalAuxDoc(Usuario $user)
    {
        return $this->obtenerPlanillaSemanal($user, 2);
    }

    // para obtener la planilla semanal de docente
    public function obtenerPlanillaSemanalDocente(Usuario $user)
    {
        return $this->obtenerPlanillaSemanal($user, 3);
    }

    // para obtener la planilla semanal dado un rol
    private function obtenerPlanillaSemanal(Usuario $user, $rol)
    {
        $codigoSis = $user->codSis;

        // ver si no se lleno la planilla de esta semana
        $llenado = $this->hayAsistencias($user, $rol);

        if (!$llenado) {
            // obteniendo horarios asignados al auxiliar actual
            $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
                ->where('activo', '=', 'true')
                ->where('rol_id', '=', $rol)
                ->orderBy('dia', 'ASC')
                ->orderBy('hora_inicio', 'ASC')
                ->get();
            $horarios = $horarios->groupBy('unidad_id');
        } else
            $horarios = collect(new HorarioClase);

        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanal' . ($rol == 3 ? 'Docente' : 'AuxDoc'), [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'nombre' => $user->nombre,
            'codSis' => $codigoSis,
            'llenado' => $llenado
        ]);
    }

    // registrar asistencias de la semana
    public function registrarAsistenciasSemana(RegistrarAsistenciaSemanalRequest $request)
    {

        // validar
        $asistencias = $request->validated()['asistencias'];
        $horario0 = HorarioClase::find(array_values($asistencias)[0]['horario_clase_id']);
        $llenado = $this->hayAsistencias(Usuario::find($horario0->asignado_codSis), $horario0->rol_id);
        if ($llenado) {
            $error = ValidationException::withMessages([
                'lleno' => ['LA PLANILLA YA FUE LLENADA']
            ]);
            throw $error;
        }

        // recorrer asistencias colocando datos extra y almacenando en bd
        foreach ($asistencias as $key => $asistencia) {
            $horario = HorarioClase::find($asistencia['horario_clase_id']);
            $asistencia['nivel'] = 2;
            $asistencia['usuario_codSis'] = $horario->asignado_codSis;
            $asistencia['materia_id'] = $horario->materia_id;
            $asistencia['grupo_id'] = $horario->grupo_id;
            $asistencia['unidad_id'] = $horario->unidad_id;
            Asistencia::create($asistencia);
        }

        return back()->with('success', "asistencias registradas!!!");
    }

    // funcion auxiliar para ver si hay asistencias en la semana para no registrar 2 veces asistencias
    private function hayAsistencias($usuario, $rol)
    {
        $fechas = getFechasDeSemanaEnFecha(date('Y-m-d'));
        $asistencias = Asistencia::where('fecha', '>=', $fechas[0])
            ->where('fecha', '<=', $fechas[5])
            ->join('Horario_clase', 'Horario_clase.id', '=', 'horario_clase_id')
            ->where('rol_id', '=', $rol)
            ->where('Horario_clase.asignado_codSis', '=', $usuario->codSis)
            ->get();
        return !$asistencias->isEmpty();
    }
}