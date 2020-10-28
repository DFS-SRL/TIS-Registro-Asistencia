<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HorarioClase extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Horario_clase';

    
    public function materia()
    {
        return $this->belongsTo('App\Materia');
    }

    public function grupo()
    {
        return $this->belongsTo('App\grupo');
    }
    
    public function asignado()
    {
        return $this->belongsTo('App\Usuario', 'asignado_codSis');
    }
        
    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }
    
}