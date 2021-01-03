<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function nombre()
    {
        return str_replace("_", " ", $this->nombre);
    }

    public function permisosPropios() {
        return $this->belongsToMany(Permiso::class, 'usuario_tiene_permiso');
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

    public function perteneceAFacultad($facultad_id) {
        return Http\Controllers\PersonalAcademicoController::perteneceAFacultad($this->codSis, $facultad_id);
    }

    public function perteneceAUnidad($unidad_id) {
        return Http\Controllers\PersonalAcademicoController::perteneceAUnidad($this->codSis, $unidad_id);
    }
}