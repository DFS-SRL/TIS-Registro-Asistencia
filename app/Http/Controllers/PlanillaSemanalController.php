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
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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

    // para obtener la planilla de excepcion de docente
    public function obtenerPlanillaExcepcionDocente(Unidad $unidad, Usuario $usuario)
    {
        $horarios =  HorarioClase::where('asignado_codSis', '=', $usuario->codSis)
            ->where('activo', '=', 'true')
            ->where('unidad_id', '=', $unidad->id)
            ->orderBy('dia', 'ASC')
            ->orderBy('hora_inicio', 'ASC')
            ->get();

        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas de excepxion
        return view('planillas.excepcion.docente', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'usuario' => $usuario,
            'unidad' => $unidad,
            'llenado' => false
        ]);
    }

    // para obtener la planilla de excepcion de auxiliar
    public function obtenerPlanillaExcepcionAuxiliar(Unidad $unidad, Usuario $usuario)
    {
        $horarios =  HorarioClase::where('asignado_codSis', '=', $usuario->codSis)
            ->where('activo', '=', 'true')
            ->where('unidad_id', '=', $unidad->id)
            ->orderBy('dia', 'ASC')
            ->orderBy('hora_inicio', 'ASC')
            ->get();

        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas de excepxion
        return view('planillas.excepcion.auxiliar', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'usuario' => $usuario,
            'unidad' => $unidad,
            'llenado' => false
        ]);
    }

    // para obtener la planilla semanal dado un rol
    private function obtenerPlanillaSemanal(Usuario $user, $rol)
    {
        $codigoSis = $user->codSis;

        // obteniendo horarios asignados al auxiliar actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
            ->where('activo', '=', 'true')
            ->where('rol_id', '=', $rol)
            ->orderBy('dia', 'ASC')
            ->orderBy('hora_inicio', 'ASC')
            ->get();

        // ver si no se lleno la planilla de esta semana
        $registradas = $this->asistenciasRegistradas($user, $rol);
        $llenado = $registradas->count() == $horarios->count() && $horarios->count() > 0;

        foreach ($horarios as $key => $horario) {
            if ($registradas->contains('id', $horario->id)) {
                $horarios->forget($key);
            }
        }

        $horarios = $horarios->groupBy('unidad_id');

        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanal' . ($rol == 3 ? 'Docente' : 'AuxDoc'), [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["SABADO"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'usuario' => $user,
            'llenado' => $llenado
        ]);
    }

    // registrar asistencias de la semana
    public function registrarAsistenciasSemana(RegistrarAsistenciaSemanalRequest $request)
    {
        // validar
        $asistencias = array_values($request->validated()['asistencias']);
        $horario0 = HorarioClase::find(array_values($asistencias)[0]['horario_clase_id']);
        $usuario = Usuario::find($horario0->asignado_codSis);
        $registradas = $this->asistenciasRegistradas($usuario, $horario0->rol_id);
        if ($registradas->count() == $this->cuantosHorarios($usuario, $horario0->rol_id)) {
            $error = ValidationException::withMessages([
                'lleno' => ['LA PLANILLA YA FUE LLENADA']
            ]);
            throw $error;
        }

        // recorrer asistencias colocando datos extra y almacenando en bd
        foreach ($asistencias as $asistencia) {
            if ($registradas->contains('id', $asistencia['horario_clase_id']))
                continue;

            // Se cambia el formato de fecha de d/m/Y a Y-m-d para la BD
            $asistencia['fecha'] = convertirFechaDMYEnYMD($asistencia['fecha']);

            $horario = HorarioClase::find($asistencia['horario_clase_id']);
            $asistencia['nivel'] = 2;
            $asistencia['usuario_codSis'] = $horario->asignado_codSis;
            $asistencia['materia_id'] = $horario->materia_id;
            $asistencia['grupo_id'] = $horario->grupo_id;
            $asistencia['unidad_id'] = $horario->unidad_id;

            if (array_key_exists('documento_adicional', $asistencia)) {
                $doc = $asistencia['documento_adicional'];
                $docNombre = pathInfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                $docExtension = $doc->getClientOriginalExtension();
                $nombreAGuardar = $docNombre . '_' . time() . '.' . $docExtension;
                $path = $doc->storeAs('documentosAdicionales', $nombreAGuardar);
                $asistencia['documento_adicional'] = $nombreAGuardar;
            }

            Asistencia::create($asistencia);
        }

        return back()->with('success', "asistencias registradas!!!");
    }

    // funcion auxiliar para ver si hay asistencias en la semana para no registrar 2 veces asistencias
    private function asistenciasRegistradas($usuario, $rol)
    {
        $fechas = getFechasDeSemanaEnFecha(date('Y-m-d'));
        return Asistencia::where('fecha', '>=', $fechas[0])
            ->where('fecha', '<=', $fechas[5])
            ->join('Horario_clase', 'Horario_clase.id', '=', 'horario_clase_id')
            ->where('rol_id', '=', $rol)
            ->where('Horario_clase.asignado_codSis', '=', $usuario->codSis)
            ->select('Horario_clase.id')
            ->get();
    }

    // contar horarios de la semana
    private function cuantosHorarios($usuario, $rol)
    {
        return HorarioClase::where('asignado_codSis', '=', $usuario->codSis)
            ->where('activo', '=', 'true')
            ->where('rol_id', '=', $rol)
            ->count();
    }
}