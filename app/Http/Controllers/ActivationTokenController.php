<?php

namespace App\Http\Controllers;

use App\ActivationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ActivationTokenController extends Controller
{
    public function activate($token){
        // $token->user->update(['active' => true]);

        // Auth::login($token->user);

        // $token->delete();

        if( !ActivationToken::where('token', $token)->get()->isEmpty() ){
            ActivationToken::where('token', $token)->first()->user->activate();
        }else{
            return redirect('/login')->withInfo('El enlace que utilizaste ya fue utilizado o ya expiró.');
        }


        return redirect('/')->withInfo('Tu cuenta ya ha sido activada, ya puedes iniciar sesión');
    }
}
