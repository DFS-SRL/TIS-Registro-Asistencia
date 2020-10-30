<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Asistencia';
    // desactivar solo si no usamos request()->all() y validado en los controllers
    protected $guarded = [];
    // quitar timestamps
    public $timestamps = false;

    public function materia()
    {
        return $this->belongsTo('App\Materia');
    }

    public function grupo()
    {
        return $this->belongsTo('App\Grupo');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Usuario');
    }

    public function horarioClase()
    {
        return $this->belongsTo('App\HorarioClase');
    }
}