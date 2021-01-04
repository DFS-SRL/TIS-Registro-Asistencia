<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    protected $fillable = ['user_id', 'text', 'link'];

    public $incrementing = true;

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }

    public function marcarComoLeida(){
        if(is_null($this->read_at)){
            $this->forceFill(['read_at' => $this->freshTimestamp()])->save();
        }
    }

    public function leida(){
        return $this->read_at !== null;
    }

    public static function notificacionesNoLeidas($usuario){
        return Notificaciones::
            where('user_id', '=', $usuario)
            ->whereNull('read_at')
            ->orderBy('created_at', 'DESC')
            ->orderBy('text', 'ASC');
            //->get();
    }

    public static function notificacionesLeidas($usuario){
        return Notificaciones::
            where('user_id', '=', $usuario)
            ->whereNotNull('read_at')
            ->orderBy('created_at', 'DESC')
            ->orderBy('text', 'ASC');
            //->get();
    }
}
