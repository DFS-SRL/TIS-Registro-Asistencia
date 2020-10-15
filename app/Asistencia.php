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
}