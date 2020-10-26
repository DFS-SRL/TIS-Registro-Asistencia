<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Asistencia;
use Illuminate\Http\Request;
use App\helpers\AsistenciaHelper;
use Illuminate\Validation\ValidationException;

class InformesController extends Controller
{
    // muestra la vista al jefe de departamento para acceder a informes semanales
    public function index(Unidad $unidad)
    {
        return view('informes.index',[
            'unidad' => $unidad
        ]);
    }
    
    // sube de nivel a las asistencias de los informes
    public function subirInformes()
    {
        calcularFechasMes(request()['fecha'], $t, $fechaInicio, $fechaFin);
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidad(
            Unidad::find(request()['unidad_id']),
            $fechaInicio,
            $fechaFin
        );
        
        foreach ($asistencias as $key => $asistencia) {
            if($asistencia->nivel == 1)
                {$error = ValidationException::withMessages([
                    'nivel1' => ['algun docente se encuentra editando su informe semanal']
                ]);
                throw $error;
            }
            if($asistencia->nivel == 3)
                {$error = ValidationException::withMessages([
                    'nivel3' => ['los informes ya fueron enviados a facultativo']
                ]);
                throw $error;
            }
        }
        $this->subirNivel($asistencias);
        return 'enviado correctamente :)';
    }

    public function subirInformesFuerza()
    {
        calcularFechasMes(request()['fecha'], $t, $fechaInicio, $fechaFin);
        $asistencias = AsistenciaHelper::obtenerAsistenciasUnidad(
            Unidad::find(request()['unidad_id']),
            $fechaInicio,
            $fechaFin
        );
        
        foreach ($asistencias as $key => $asistencia) {
            if($asistencia->nivel == 3)
                {$error = ValidationException::withMessages([
                    'nivel3' => ['los informes ya fueron enviados a facultativo']
                ]);
                throw $error;
            }
        }
        $this->subirNivel($asistencias);
        return 'enviado correctamente :)';
    }

    private function subirNivel($asistencias)
    {
        foreach ($asistencias as $key => $asistencia) {
            
        }
    }
}