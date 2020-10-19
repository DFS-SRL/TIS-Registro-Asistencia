<?php

namespace App\Http\Controllers;

use App\Rol;
use App\Unidad;
use App\Usuario;
use Carbon\Carbon;
use App\Asistencia;
use Illuminate\Http\Request;
use App\Helpers\AsistenciaHelper;
use Illuminate\Support\Facades\DB;

class ParteMensualController extends Controller
{
    public function obtenerParteAuxiliares(Unidad $unidad, $fecha)
    {
        // obtener fechas inicio y fin del mes
        $t = Carbon::now();
        if($t->day <= 15)
            $t->subMonth();
        $t->day = 15;
        $fechaFin = $t->toDateString();
        $t->subMonth();
        $t->addDay();
        $fechaInicio = $t->toDateString();
        
        // obtener usuarios con rol
        $auxLabo = $this->usuariosRolUnidad(1, $unidad);
        $auxDoc = $this->usuariosRolUnidad(2, $unidad);

        // inicializar tiempos para horas pagables
        $tiempoInicio = $this->tiempoCero();
        $totPagables = $this->tiempoCero();
        $totNoPagables = $this->tiempoCero();

        // obtener partes 
        $parteLabo = $this->parteMensual($auxLabo, $unidad, 1, $fechaInicio, $fechaFin, $totPagables, $totNoPagables);
        $parteDoc = $this->parteMensual($auxDoc, $unidad, 1, $fechaInicio, $fechaFin, $totPagables, $totNoPagables);
        
        // calcular horas pagables y no pagables totales
        $totPagables = $totPagables->floatDiffInHours($tiempoInicio);
        $totNoPagables = $totNoPagables->floatDiffInHours($tiempoInicio);
        
        // devolver la vista de parte mensual de auxiliares
        return view('parteMensual.auxiliares', [
            'unidad' => $unidad,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'gestion' => $t->year,
            'parteLabo' => $parteLabo,
            'parteDoc' => $parteDoc,
            'totPagables' => $totPagables,
            'totNoPagables' => $totNoPagables
        ]);
    }

    // obtiene parte mensual (pagable y no pagable se van sumando y se recupera pase por referencia)
    private function parteMensual($usuarios, $unidad, $rol, $fechaInicio, $fechaFin, Carbon $pagable, Carbon $noPagable)
    {
        $parte = [];
        foreach ($usuarios as $key => $usuario) {
            $asistencias = AsistenciaHelper::obtenerAsistenciasUsuario($unidad, 1, $fechaInicio, $fechaFin, $usuario);
            $reporte = [
                'codSis' => $usuario->codSis,
                'nombre' => $usuario->nombre,
                'cargaHoria' => 0.0,
                'asistidas' => 0.0,
                'falta' => 0.0,
                'licencia' => 0.0,
                'baja' => 0.0,
                'declaratoria' => 0.0,
                'pagables' => 0.0,
                'noPagable' => 0.0
            ];
            foreach ($asistencias as $key => $asistencia) {
                
            }
            array_push($parte, $reporte);
        }
        return $parte;
    }

    // da usuarios de cierto rol que pertenecen a cierta unidad
    private function usuariosRolUnidad($rol, $unidad)
    {
        return Usuario::join('Usuario_tiene_rol', 'Usuario.codSis', '=', 'Usuario_tiene_rol.usuario_codSis')
                        ->where('Usuario_tiene_rol.rol_id', '=', $rol)
                        ->join('Usuario_pertenece_unidad', 'Usuario.codSis', '=', 'Usuario_pertenece_unidad.usuario_codSis')
                        ->where('Usuario_pertenece_unidad.unidad_id', '=', $unidad->id)
                        ->select('Usuario.codSis', 'Usuario.nombre')
                        ->get();
    }

    // tiempo inicial para hacer calculos
    private function tiempoCero()
    {
        return Carbon::createFromFormat('d/m/Y H:i:s',  '01/01/2000 00:00:00');
    }

}