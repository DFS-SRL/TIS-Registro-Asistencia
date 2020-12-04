<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facultad extends Model
{
    protected $table = 'public.Facultad';
    // desactivar solo si no usamos request()->all() y validado en los controllers
    protected $guarded = [];
    // quitar timestamps
    public $timestamps = false;

    public function encargado()
    {
        return $this->belongsTo('App\Usuario', 'encargado_codSis');
    }

    public function directorAcademico()
    {
        return $this->belongsTo('App\Usuario', 'director_codSis');
    }

    public function decano()
    {
        return $this->belongsTo('App\Usuario', 'decano_codSis');
    }
}