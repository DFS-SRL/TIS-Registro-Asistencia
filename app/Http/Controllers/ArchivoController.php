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

    // TODO: falta restringir la descarga de documentos mediante url de usuarios ajenos

    // Descargar documento adicional por nombre
    public function descargarPorNombre($nombre) {
        return Storage::download('/documentosAdicionales/'.$nombre);
    }

    // Eliminar un documento adicional
    public function eliminarDocumentoAdicional($nombre) {
        if (!Auth::user()->usuario->tienePermisoNombre('editar asistencia')) {
            return view('provicional.noAutorizado');
        }
        return Storage::delete();
    }

    private function codigoSisDeDocumento($nombre) {
        return Asistencia::where('documento_adicional', $nombre)->first()->usuario_codSis;
    }
}
