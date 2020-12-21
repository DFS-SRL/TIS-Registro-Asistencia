<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParteMensual extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Parte_mensual';
    // desactivar solo si no usamos request()->all() y validado en los controllers
    protected $guarded = [];
    // quitar timestamps
    public $timestamps = false;
}
