<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;
use App\Asistencia;

class ArchivoController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    // Descargar documento adicional por nombre
    public function descargarPorNombre($nombre) {
        // Verificar que el documento pertenezca al usuario o que el usuario sea jefe de departamento
        if ($this->codigoSisDeDocumento($nombre) != Auth::user()->usuario->codSis) {
            if (!UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, [4], null)) {
                return view('provicional.noAutorizado');
            }
        }
        return Storage::download('/documentosAdicionales/'.$nombre);
    }

    // Eliminar un documento adicional
    // La documentacion dice que devuelve un booleano pero no lo probe
    public function eliminarDocumentoAdicional($nombre) {
        // Verificar que el documento pertenezca al usuario o que el usuario sea jefe de departamento
        if ($this->codigoSisDeDocumento($nombre) != Auth::user()->usuario->codSis) {
            if (!UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, [4], null)) {
                return view('provicional.noAutorizado');
            }
        }
        return Storage::delete();
    }

    private function codigoSisDeDocumento($nombre) {
        return Asistencia::where('documento_adicional', $nombre)->first()->usuario_codSis;
    }
}
