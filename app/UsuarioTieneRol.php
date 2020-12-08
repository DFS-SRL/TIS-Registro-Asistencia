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
}