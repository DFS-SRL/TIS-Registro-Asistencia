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
                                    ->orderBy('dia', 'ASC')
                                    ->orderBy('hora_inicio', 'ASC')
                                    ->get();

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
                            -> where('Rol.id', '=', 2)
                            -> join('Horario_clase', 'Horario_clase.asignado_codSis', '=', 'codSis')
                            -> where('Horario_clase.grupo_id', '=', $grupo->id)
                            -> select('Usuario.codSis', 'Usuario.nombre')
                            -> get() -> first();

        return [$grupo, $horarios, $docente, $auxiliar];
    }
}
