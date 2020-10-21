<?php

namespace App\Http\Controllers;

use App\Usuario;
use App\HorarioClase;
use App\Unidad;
use Illuminate\Http\Request;

class PlanillaSemanalDocenteController extends Controller
{
    public function obtenerPlanillaSemana(Usuario $user)
    {
        // Para obtener los horarios separados por departamentos, sacamos una lista
        // de todos los departamentos y luego recorremos la lista sacando todos
        // los horarios que tiene el docente en cada departamento
        
        // El resultado sera un arreglo de arreglos de HorarioClase
        $horariosPorDpto = [];
        $departamentos = Unidad::all();

        foreach ($departamentos as $dpto) {
            $horarios = HorarioClase::where('asignado_codSis', '=', $user->codSis)-> where('rol_id', '=', 3)-> where('unidad_id', '=', $dpto->id)-> orderBy('dia', 'ASC')-> get();
            if (!$horarios->isEmpty())
                array_push($horariosPorDpto, $horarios);
        }

        //return $horariosPorDpto;
        $fechasDeSemana = getFechasDeSemanaActual();

        // devolver vista de planillas semanales
        return view('planillas.semanalDocente', [
            'fechaInicio' => $fechasDeSemana["LUNES"],
            'fechaFinal' => $fechasDeSemana["VIERNES"],
            'fechasDeSemana' => $fechasDeSemana,
            'horarios' => $horariosPorDpto
        ]);
    }
}