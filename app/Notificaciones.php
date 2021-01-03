<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    protected $fillable = ['id','user_id'];

    public function usuario(){
        return $this->belongsTo('App\Usuario');
    }
}
