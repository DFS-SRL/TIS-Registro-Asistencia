<?php

namespace App\Http\Controllers;

use App\ActivationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivationTokenController extends Controller
{
    public function activate(ActivationToken $token){
        // $token->user->update(['active' => true]);

        // Auth::login($token->user);

        // $token->delete();

        $token->user->activate();

        return redirect('/')->withInfo('Tu cuenta ya ha sido activada, ya puedes iniciar sesión');
    }
}
