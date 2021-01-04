<?php

namespace App\Http\Controllers;

use App\Notificaciones;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $codSis = auth()->user()->usuario->codSis;

        return view('personal.notificaciones', [
            'notificacionesLeidas' => Notificaciones::notificacionesLeidas($codSis),
            'notificacionesNoLeidas' => Notificaciones::notificacionesNoLeidas($codSis)
        ]);
    }

    public function leer(Notificaciones $id){
        $id->marcarComoLeida();

        return back()->withInfo('Notificacion marcada como leída.');
    }
}
