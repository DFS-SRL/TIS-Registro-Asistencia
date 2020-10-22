<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Grupo';

    public function materia() {
        return $this->belongsTo('App\Materia');
    }

    public function unidad() {
        return $this->belongsTo('App\Unidad');
    }
}