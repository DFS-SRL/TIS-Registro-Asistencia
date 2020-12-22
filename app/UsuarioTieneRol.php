<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioTieneRol extends Model
{
    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = ['rol_id','usuario_codSis','departamento_id'];

    protected $primaryKey = ['rol_id','usuario_codSis','departamento_id'];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Usuario_tiene_rol';

    public static function verificarRolEnDepartamento($usuario_codSis, $rol_id, $departamento_id) {
        return UsuarioTieneRol::where('rol_id' , $rol_id)
        ->where('usuario_codSis', $usuario_codSis)
        ->where('departamento_id', $departamento_id)->exists();
    }

    public static function alMenosUnRol($usuario_codSis, $rolesPermitidos, $departamento_id = null) {
        $alMenosUno = false;
        if ($departamento_id == null) {
            foreach ($rolesPermitidos as $rol_id ) {
                $existe = UsuarioTieneRol::where('rol_id' , $rol_id)
                ->where('usuario_codSis', $usuario_codSis)->exists();
                if ($existe) $alMenosUno = true;
            }
        }
        else {
            foreach ($rolesPermitidos as $rol_id ) {
                $existe = UsuarioTieneRol::where('rol_id' , $rol_id)
                ->where('usuario_codSis', $usuario_codSis)
                ->where('departamento_id', $departamento_id)->exists();
                if ($existe) $alMenosUno = true;
            }
        }
        return $alMenosUno;
    }
}