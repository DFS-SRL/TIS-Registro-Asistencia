<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Unidad';
    // desactivar solo si no usamos request()->all() y validado en los controllers
    protected $guarded = [];
    // quitar timestamps
    public $timestamps = false;

    public function facultad()
    {
        return $this->belongsTo('App\Facultad');
    }
    public function jefe()
    {
        return $this->belongsTo('App\Usuario');
    }
}