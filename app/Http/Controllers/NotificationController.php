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

        $noti = Notificaciones::where('user_id', '=', $codSis)->get();

        return view('personal.notificaciones', [
            'notificaciones' => $noti
        ]);
    }
}
