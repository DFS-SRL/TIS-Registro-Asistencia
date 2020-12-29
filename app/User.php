<?php

namespace App;

use App\Http\Controllers\PersonalAcademicoController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active'
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

    public function activate(){
        $this->update(['active' => true]);

        Auth::login($this);

        $this->token->delete();

    }

    public function token(){
        return $this->hasOne(ActivationToken::class);
    }

    public function forgotPasswordToken(){
        return $this->hasOne(ForgotPasswordToken::class);
    }

    public function usuario() {
        return $this->belongsTo('App\Usuario');
    }

    public static function esJefeDepartamento($unidad_id){
        return PersonalAcademicoController::esJefeDepartamento(auth()->user()->usuario->codSis, $unidad_id);        
    }
    public static function aproboParte($idParte){
        return PersonalAcademicoController::personalAproboParte(auth()->user()->usuario->codSis, $idParte);     
    }
    private static function esDelRol($rol){
        $user = auth()->user()->usuario;
        
        $codigoSis = $user->codSis;

        // obteniendo horarios asignados al auxiliar actual
        $horarios =  self::getHorarios($codigoSis, $rol);

        return !empty($horarios);
    }

    public static function esAuxDoc(){
        return self::esDelRol(2);
    }

    public static function esDocente(){
        return self::esDelRol(3);
    }

    public static function tieneAlMenosUnRol($roles) {
        return UsuarioTieneRol::alMenosUnRol(auth()->user()->usuario_codSis, $roles);
    }

    private static function getHorarios($codigoSis, $rol){
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
        return $horarios;
    }

    // Devuelve el id del departamento del que el usuario es jefe, si es que es jefe de departamento
    public function deparatmentoEncargado() {
        $codSis = $this->usuario_codSis;
        $unidad = Unidad::where('jefe_codSis', $codSis)->get();
        return $unidad->first();
    }

    public static function inicioSesion($user){
        $autenticado = auth()->user()->usuario;
        return $user->codSis === $autenticado->codSis;
    }
    public static function esEncargadoFac($facultad_id){
        $user = auth()->user()->usuario;
        $codigoSis = $user->codSis;
        return PersonalAcademicoController::esEncargadoFac($codigoSis,$facultad_id);
    }
}
