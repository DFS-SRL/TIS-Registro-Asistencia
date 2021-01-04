<?php

namespace App\Http\Controllers\Auth;

use App\ForgotPasswordToken;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\User;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index(){
        return view('provicional.forgot-password');
    }

    public function sendEmail(Request $request){
        if(!is_numeric($request->codSis)){
            return back()->withInfo('El código sis tiene que ser númerico.');
        }

        if(!ForgotPasswordToken::where('user_id', $request->codSis)->get()->isEmpty()){
            return back()->withErrors('Existe una petición activa, por favor revisa tu correo.');
        }

        $user = User::where('usuario_codSis', '=', $request->codSis)->first();

        // Auth::login($user);
        $token = ForgotPasswordToken::create([
            'user_id' => $user->id,
            'token' => Str::random(60),
            'created_at' => Carbon::now(),
        ]);

        // return $token;

        Mail::to($user->email)->send(new ForgotPassword($user));
        return redirect('/login')->withInfo('Se ha enviado un correo con instrucciones para la recuperación. Tiene un plazo de 24 horas para usar el enlace.');
    }

    public function authUser($token){
        $data = ForgotPasswordToken::where('token', $token);
        if( !$data->get()->isEmpty() ){
            $today = Carbon::now();
            $tokenDay = $data->first()->created_at;
            
            $user = $data->first()->user;

            $user->forgotPasswordToken->delete();

            if($today->diffInDays($tokenDay) > 0){
                return redirect('/login')->withErrors('El enlace que seguiste ya expiró.');
            }
            
            Auth::login($user);
            return redirect('/reset-password')->withInfo('Se ha habilitado el cambio de tu contraseña.');
        }else{
            return redirect('/login')->with('error', 'El enlace que seguiste ya fue utilizado o ya expiró.');
        }
        // Auth::login($token->user);
        // return redirect('/reset-password')->withInfo('Se ha habilitado el cambio de tu contraseña.');
    }
}
