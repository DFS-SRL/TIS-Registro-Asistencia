<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public.Usuario';

    protected $primaryKey = 'codSis';
    
    public function getRouteKeyName()
    {
        return 'codSis';
    }

    public function rol()
    {
        return $this->belongsTo('App\Rol');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Unidad');
    }
}