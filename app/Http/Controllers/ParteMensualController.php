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
    // dada unidad y fecha devuelve vista de parte de auxiliares
    public function obtenerParteAuxiliares(Unidad $unidad, $fecha)
    {
        // obtener fechas inicio y fin del mes
        calcularFechasMes($fecha, $t, $fechaInicio, $fechaFin);
        
        // obtener usuarios con rol
        $auxLabo = $this->usuariosRolUnidad(1, $unidad);
        $auxDoc = $this->usuariosRolUnidad(2, $unidad);

        // inicializar horas pagables en 0
        $totPagables = 0;
        $totNoPagables = 0;

        // obtener partes 
        $parteLabo = $this->parteMensual($auxLabo, $unidad, 1, $fechaInicio, $fechaFin, $totPagables, $totNoPagables);
        $parteDoc = $this->parteMensual($auxDoc, $unidad, 2, $fechaInicio, $fechaFin, $totPagables, $totNoPagables);

        $parteCombinado = $this->combinar($parteLabo, $parteDoc);

        // devolver la vista de parte mensual de auxiliares
        return view('parteMensual.auxiliares', [
            'unidad' => $unidad,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'gestion' => $t->year,
            'parteLabo' => $parteLabo,
            'parteDoc' => $parteDoc,
            'parteCombinado' => $parteCombinado,
            'totPagables' => $totPagables,
            'totNoPagables' => $totNoPagables
        ]);
    }

    // dada unidad y fecha devuelve vista de parte de docentes
    public function obtenerParteDocentes(Unidad $unidad, $fecha)
    {
        // obtener fechas inicio y fin del mes
        calcularFechasMes($fecha, $t, $fechaInicio, $fechaFin);
        
        // obtener usuarios con rol docente
        $docentes = $this->usuariosRolUnidad(3, $unidad);

        // inicializar horas pagables en 0
        $totPagables = 0;
        $totNoPagables = 0;

        // obtener parte
        $parteDoc = $this->parteMensual($docentes, $unidad, 3, $fechaInicio, $fechaFin, $totPagables, $totNoPagables);

        // devolver la vista de parte mensual de auxiliares
        return view('parteMensual.docentes', [
            'unidad' => $unidad,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'gestion' => $t->year,
            'parteDoc' => $parteDoc,
            'totPagables' => $totPagables,
            'totNoPagables' => $totNoPagables
        ]);
    }


    // obtiene parte mensual (pagable y no pagable se van sumando y se recupera pase por referencia)
    private function parteMensual($usuarios, $unidad, $rol, $fechaInicio, $fechaFin, &$pagable, &$noPagable)
    {
        $parte = [];
        $periodo = $rol == 1 ? 60 : 45;
        foreach ($usuarios as $key => $usuario) {
            $asistencias = AsistenciaHelper::obtenerAsistenciasUsuario($unidad, $rol, $fechaInicio, $fechaFin, $usuario);
            $reporte = [
                'codSis' => $usuario->codSis,
                'nombre' => $usuario->nombre,
                'cargaHoraria' => 0.0,
                'asistidas' => 0.0,
                'falta' => 0.0,
                'LICENCIA' => 0.0,
                'BAJA_MEDICA' => 0.0,
                'DECLARATORIA_EN_COMISION' => 0.0,
                'pagable' => 0.0,
                'noPagable' => 0.0
            ];
            foreach ($asistencias as $key => $asistencia) {
                $inicio = $asistencia->horarioClase->hora_inicio;
                $fin = $asistencia->horarioClase->hora_fin;
                $horas = tiempoHora($inicio)->diffInMinutes(tiempoHora($fin)) / $periodo;
                $reporte['cargaHoraria'] += $horas;
                if($asistencia->asistencia)
                {
                    $reporte['pagable'] += $horas;
                    $reporte['asistidas'] += $horas;
                }
                else
                {
                    if($asistencia->permiso && $asistencia->permiso == 'DECLARATORIA_EN_COMISION')
                        $reporte['pagable'] += $horas;
                    else
                        $reporte['noPagable'] += $horas;
                    if($asistencia->permiso)
                        $reporte[$asistencia->permiso] += $horas;
                    else
                        $reporte['falta'] += $horas;
                }
            }
            $pagable += $reporte['pagable'];
            $noPagable += $reporte['noPagable'];
            $parte[$usuario->codSis] = $reporte;
        }
        return $parte;
    }

    // combina las horas de 2 partes
    private function combinar($parte1, $parte2)
    {
        foreach ($parte2 as $key => $reporte) {
            if(array_key_exists($key, $parte1))
            {
                foreach ($reporte as $key1 => $value)
                    if($key1 != 'codSis' && $key1 != 'nombre')
                        $parte1[$key][$key1] += $value;
            }
            else
                $parte1[$key] = $reporte;
        }
        usort($parte1, function ($a, $b) { return $a['nombre'] < $b['nombre'] ? -1 : 1; });
        return $parte1;
    }

    // da usuarios de cierto rol que pertenecen a cierta unidad
    private function usuariosRolUnidad($rol, $unidad)
    {
        return Usuario::join('Usuario_tiene_rol', 'Usuario.codSis', '=', 'Usuario_tiene_rol.usuario_codSis')
                        ->where('Usuario_tiene_rol.rol_id', '=', $rol)
                        ->join('Usuario_pertenece_unidad', 'Usuario.codSis', '=', 'Usuario_pertenece_unidad.usuario_codSis')
                        ->where('Usuario_pertenece_unidad.unidad_id', '=', $unidad->id)
                        ->select('Usuario.codSis', 'Usuario.nombre')
                        ->orderBy('Usuario.nombre')
                        ->get();
    }
}