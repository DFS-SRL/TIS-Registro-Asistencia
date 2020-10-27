<?php

namespace App\Http\Controllers;

use App\Grupo;
use App\HorarioClase;
use App\Usuario;
use App\UsuarioTieneRol;
use App\Rol;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function mostrarInformacion(Grupo $grupo) {
        // Obtener los horarios correspondientes a la materia
        $horarios = HorarioClase::where('grupo_id', '=', $grupo->id)
                                    ->get();

        $horarios = $horarios->sort( function(HorarioClase $a, HorarioClase $b) {
            $diffDias = compararDias($a->dia, $b->dia);
            if ($diffDias === 0) {
                return ( $a->hora_inicio < $b->hora_inicio ? -1 : 1 );
            }
            else {
                return $diffDias;
            }
        } )->values();

        // IMPORTANTE
        // Se asume que cada grupo tiene asignado maximo un docente y un auxiliar

        // Obtiene el docente asignado al grupo
        $docente = Usuario::join('Usuario_tiene_rol', 'Usuario_tiene_rol.usuario_codSis', '=', 'codSis')
                            -> join('Rol', 'Rol.id', '=', 'Usuario_tiene_rol.rol_id') 
                            -> where('Rol.id', '=', 3)
                            -> join('Horario_clase', 'Horario_clase.asignado_codSis', '=', 'codSis')
                            -> where('Horario_clase.grupo_id', '=', $grupo->id)
                            -> select('Usuario.codSis', 'Usuario.nombre')
                            -> get() -> first();
        
        // Obtiene el auxiliar asignado al grupo
        $auxiliar = Usuario::join('Usuario_tiene_rol', 'Usuario_tiene_rol.usuario_codSis', '=', 'codSis')
                            -> join('Rol', 'Rol.id', '=', 'Usuario_tiene_rol.rol_id') 
                            -> where('Rol.id', '<=', 2)
                            -> join('Horario_clase', 'Horario_clase.asignado_codSis', '=', 'codSis')
                            -> where('Horario_clase.grupo_id', '=', $grupo->id)
                            -> select('Usuario.codSis', 'Usuario.nombre')
                            -> get() -> first();

        // Se calcula la carga horaria
        $cargaHorariaDocente = 0;
        $cargaHorariaAuxiliar = 0;
        foreach ($horarios as $horario) {
            if ($docente != null && $horario->asignado_codSis == $docente->codSis) {
                $cargaHorariaDocente += tiempoHora($horario->hora_inicio)
                                        ->diffInMinutes(tiempoHora($horario->hora_fin)) 
                                        / 45;
            }
            if ($auxiliar != null && $horario->asignado_codSis == $auxiliar->codSis) {
                $cargaHorariaAuxiliar += tiempoHora($horario->hora_inicio)
                                        ->diffInMinutes(tiempoHora($horario->hora_fin))
                                        / ($horario->rol_id == 2 ? 45 : 60);
            }
        }

        return view('informacion.grupo', [
            'grupo' => $grupo,
            'horarios' => $horarios,
            'docente' => $docente,
            'auxiliar' => $auxiliar,
            'cargaHorariaDocente' => $cargaHorariaDocente,
            'cargaHorariaAuxiliar' => $cargaHorariaAuxiliar
        ]);
    }
}
