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

    public static function esDocente(){
        $user = auth()->user()->usuario;
        
        $codigoSis = $user->codSis;

        $rol = 3;

        // obteniendo horarios asignados al auxiliar actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $codigoSis)
            ->where('activo', '=', 'true')
            ->where('rol_id', '=', $rol)
            ->orderBy(
                'dia',
                'ASC'
            )
            ->orderBy('hora_inicio', 'ASC')
            ->get();

        $horarios = $horarios->groupBy('unidad_id');

        return !empty($horarios);
    }

    public static function inicioSesion($user){
        $autenticado = auth()->user()->usuario;
        return $user->codSis === $autenticado->codSis;
    }
}
