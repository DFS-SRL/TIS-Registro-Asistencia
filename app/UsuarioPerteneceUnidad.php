<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioPerteneceUnidad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $fillable = ['usuario_codSis','unidad_id','jefe_dept'];

    public $timestamps = false;
    
    public $incrementing = false;

    protected $primaryKey = ['usuario_codSis', 'unidad_id'];
    
    protected $table = 'public.Usuario_pertenece_unidad';
}