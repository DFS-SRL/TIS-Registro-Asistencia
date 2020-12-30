<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username() {
        return 'usuario_codSis';
    }

    public function login(){
        $credentials = $this->validate(
            request(),
            [
                'usuario_codSis' => 'required|integer',
                'password' => 'required|string'
            ]
        );

        $remember_me = ( !empty( request()->remember_me ) )? TRUE : FALSE;

        if(Auth::attempt($credentials)){
            $user = User::where(["usuario_codSis" => $credentials['usuario_codSis']])->first();
    
            Auth::login($user, $remember_me);

            return redirect()->intended('/');
        }
        
        return back()
            ->withErrors('Estas credenciales no concuerdan con nuestros registros o falta activación.')
            ->withInput(request(['usuario_codSis']));
    }
    
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->loggedOut($request) ?: redirect('/login');
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');

        $credentials['active'] = true;

        return $credentials;
    }
}
