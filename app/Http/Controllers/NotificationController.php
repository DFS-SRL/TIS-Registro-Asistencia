<?php

namespace App\Http\Controllers;

use App\Notificaciones;
use App\Usuario;
use Carbon\Carbon;
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
            'notificaciones' => Notificaciones::notificacionesNoLeidas($codSis)->unionAll(Notificaciones::notificacionesLeidas($codSis))->paginate(10)
        ]);
    }

    public function leer(Notificaciones $id){
        $id->marcarComoLeida();

        return back()->with('success', 'Notificacion marcada como leída.');
    }

    public function marcarLeidasTodas (Usuario $usuario){
        $noti = $usuario->notificaciones()->where('read_at', '=', null)->get();

        // return $noti;

        foreach ($noti as $n) {
            $n->marcarComoLeida();
        }

        return back()->with('success', 'Todas las notificaciones marcadas como leidas.');
    }
}
