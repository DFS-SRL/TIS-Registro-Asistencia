<?php

namespace App;

use App\Http\Controllers\PersonalAcademicoController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'public.users';

    public function usuario() {
        return $this->belongsTo('App\Usuario');
    }

    public static function esJefeDepartamento($unidad_id){
        return PersonalAcademicoController::esJefeDepartamento(auth()->user()->usuario->codSis, $unidad_id);
    }
}
