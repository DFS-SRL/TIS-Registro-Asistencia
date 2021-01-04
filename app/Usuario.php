<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Usuario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Usuario';

    public $incrementing = false;

    protected $fillable = ['codSis','nombre','contrasenia','correo_electronico'];

    protected $primaryKey = 'codSis';

    protected $hidden = [
        'contrasenia'
    ];

    public $timestamps = false;
    
    public function getRouteKeyName()
    {
        return 'codSis';
    }

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }

    public function roles() {
        return $this->belongsToMany(Rol::class, 'Usuario_tiene_rol');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }

    public function notificaciones(){
        return $this->hasMany('App\Notificaciones', 'user_id', 'codSis');
    }

    public function notificacionesNoLeidas(){
        return Notificaciones::notificacionesNoLeidas($this->codSis);
    }

    public function nombre()
    {
        return str_replace("_", " ", $this->nombre);
    }

    public function permisosPropios() {
        return $this->belongsToMany(Permiso::class, 'usuario_tiene_permiso', 'usuario_codsis', 'permiso_id');
    }

    public function tienePermisoNombre($permisoNombre) {
        // Primero revisamos si su rol tiene los permisos
        $roles = $this->roles;
        foreach ($roles as $rol ) {
            if ($rol->tienePermisoNombre($permisoNombre)) return true;
        }
        // Ahora revisamos si el usuario tiene el permiso asignado
        $permisos = $this->permisosPropios;
        foreach ($permisos as $permiso ) {
            if ($permiso->nombre == $permisoNombre) return true;
        }

        return false;
    }

    public function todosLosPermisos() {
        $permisos = new Collection;
        $roles = $this->roles;
        foreach ($roles as $rol ) {
            return $rol->permisos;
            $permisos = $permisos->merge($rol->permisos);
        }
        $permisos = $permisos->merge($this->permisosPropios);
        return $permisos;
    }

    public function perteneceAFacultad($facultad_id) {
        if (UsuarioTieneRol::where('usuario_codSis', $this->codSis)->where('rol_id', 8)->exists()) return true;
        return Http\Controllers\PersonalAcademicoController::perteneceAFacultad($this->codSis, $facultad_id);
    }

    public function perteneceAUnidad($unidad_id) {
        if (UsuarioTieneRol::where('usuario_codSis', $this->codSis)->where('rol_id', 8)->exists()) return true;
        return Http\Controllers\PersonalAcademicoController::perteneceAUnidad($this->codSis, $unidad_id);
    }

    public function mismoDepartamento(Usuario $otroUsuario) {
        $rolesOtro = UsuarioTieneRol::where('usuario_codSis', $otroUsuario->codSis);
        $rolesMios = UsuarioTieneRol::where('usuario_codSis', $this->codSis);
        foreach ($rolesOtro as $rolOtro ) {
            foreach ($rolesMios as $rolMio ) {
                if ($rolOtro->departamento_id == $rolMio->departamento_id) 
                    return true;
                if (Unidad::find($rolOtro->departamento_id)->facultad_id == $rolMio->facultad_id)
                    return true;
            }
        }
        return false;
    }
}