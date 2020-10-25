<?php

namespace App\Http\Controllers;
use App\Usuario;
use App\HorarioClase;
use App\Unidad;
use App\Asistencia;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrarAsistenciaSemanalRequest;

class RegistrarAsistenciaSemanal extends Controller
{
    //
    
    
    public function registrarAsistencia(RegistrarAsistenciaSemanalRequest $request)
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
