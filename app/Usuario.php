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

    public $incrementing = false;

    protected $fillable = ['codSis','nombre','contrasenia','correo_electronico'];

    protected $primaryKey = 'codSis';

    protected $hidden = [
        'contrasenia'
    ];

    public $timestamps = false;
    
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

    public function nombre()
    {
        return str_replace("_", " ", $this->nombre);
    }
}