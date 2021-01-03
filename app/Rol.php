<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Rol';

    public function permisos() {
        return $this->belongsToMany(Permiso::class, 'rol_tiene_permiso');
    }

    public function tienePermisoNombre($permisoNombre) {
        $permisos = $this->permisos;
        foreach ($permisos as $permiso ) {
            if ($permiso->nombre == $permisoNombre) return true;
        }
        return false;
    }
}