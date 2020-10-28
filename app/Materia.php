<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Materia';
    // desactivar solo si no usamos request()->all() y validado en los controllers
    protected $guarded = [];
    // quitar timestamps
    public $timestamps = false;

    public function unidad() {
        return $this->belongsTo('App\Unidad');
    }
}