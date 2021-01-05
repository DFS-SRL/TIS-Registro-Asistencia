<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioTienePermiso extends Model
{
    protected $fillable = ['usuario_codsis','permiso_id'];

    public $timestamps = false;
    
    public $incrementing = false;

    protected $primaryKey = ['usuario_codsis', 'permiso_id'];
    
    protected $table = 'public.usuario_tiene_permiso';
}
