<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolTienePermiso extends Model
{
    protected $fillable = ['rol_id','permiso_id'];

    public $timestamps = false;
    
    public $incrementing = false;

    protected $primaryKey = ['rol_id', 'permiso_id'];
    
    protected $table = 'public.rol_tiene_permiso';
}
