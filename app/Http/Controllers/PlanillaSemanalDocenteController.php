<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\HorarioClase;
use App\Unidad;
use App\Asistencia;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrarAsistenciaDocenteRequest;

class PlanillaSemanalDocenteController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        $codigoSis = $user->codSis;
        $nombre = Usuario::where('codSis','=',$codigoSis)->value('nombre');

        $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
                                    ->where('rol_id', '=', 3)
                                    ->orderBy('dia', 'ASC')
                                    ->get();


        $horarios =$horarios->groupBy('unidad_id');
        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanalDocente', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["VIERNES"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horarios,
            'nombre' => $nombre,
            'codSis' => $codigoSis
        ]);
    }

    
    public function registrarAsistencia(RegistrarAsistenciaDocenteRequest $request)
    {
        
        // validar
        $asistencias = $request->validated()['asistencias'];
        
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
        
        return "asistencias registradas!!!";
    }

}