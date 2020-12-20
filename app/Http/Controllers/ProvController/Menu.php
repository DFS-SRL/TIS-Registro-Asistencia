<?php

namespace App\Http\Controllers\ProvController;

use App\Unidad;
use App\Usuario;
use App\UsuarioTieneRol;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;

class Menu extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }	
    
    //Para cada tipo de usuario 
    //se deben mostrar sus nombres completos
    //en un enlace

    public function docentes()
    {
        $docentes = UsuarioTieneRol::where('rol_id', '=', 3)
            ->join('public.Usuario', 'public.Usuario_tiene_rol.usuario_codSis', '=', 'public.Usuario.codSis')
            ->select('public.Usuario_tiene_rol.usuario_codSis', 'public.Usuario.nombre')
            ->distinct()
            ->paginate(10);
        // return $docentes;
        return view('provicional.docentes', [
            'docentes' => $docentes
        ]);
    }
    public function docente(Usuario $usuario)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [3,4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        // Un docente solo puede entrar a su propio menu
        $rolesPermitidos = [3]
        if (UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null)) {
            if ($usuario->codSis != Auth::user()->usuario->codSis) {
                return view('provicional.noAutorizado'); 
            }
        }
        
        return view('provicional.docente', [
            'usuario' => $usuario
        ]);
    }
    public function auxiliarDoc(Usuario $usuario)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [2,4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        // Un auxiliar solo puede entrar a su propio menu
        $rolesPermitidos = [2]
        if (UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null)) {
            if ($usuario->codSis != Auth::user()->usuario->codSis) {
                return view('provicional.noAutorizado'); 
            }
        }

        return view('provicional.auxiliarDoc', [
            'usuario' => $usuario
        ]);
    }
    public function auxiliarLabo(Usuario $usuario)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [1,4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        // Un auxiliar solo puede entrar a su propio menu
        $rolesPermitidos = [1]
        if (UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null)) {
            if ($usuario->codSis != Auth::user()->usuario->codSis) {
                return view('provicional.noAutorizado'); 
            }
        }

        return view('provicional.auxiliarLabo', [
            'usuario' => $usuario
        ]);
    }
    public function auxiliaresDoc()
    {
        $auxiliaresDoc = UsuarioTieneRol::where('rol_id', '=', 2)
            ->join('public.Usuario', 'public.Usuario_tiene_rol.usuario_codSis', '=', 'public.Usuario.codSis')
            ->select('public.Usuario_tiene_rol.usuario_codSis', 'public.Usuario.nombre')
            ->distinct()
            ->paginate(10);
        // return $docentes;
        return view('provicional.auxiliaresDoc', [
            'auxiliaresDoc' => $auxiliaresDoc
        ]);
    }
    public function auxiliaresLabo()
    {
        $auxiliaresLabo = UsuarioTieneRol::where('rol_id', '=', 1)
            ->join('public.Usuario', 'public.Usuario_tiene_rol.usuario_codSis', '=', 'public.Usuario.codSis')
            ->select('public.Usuario_tiene_rol.usuario_codSis', 'public.Usuario.nombre')
            ->distinct()
            ->paginate(10);
        // return $docentes;
        return view('provicional.auxiliaresLabo', [
            'auxiliaresLabo' => $auxiliaresLabo
        ]);
    }
    public function departamentos()
    {
        $departamentos = Unidad::get();
        // return $docentes;
        return view('provicional.departamentos', [
            'departamentos' => $departamentos
        ]);
    }
    public function jefesDept()
    {
        return view('provicional.jefesDept');
    }
    public function encargadosAsist()
    {
        return view('provicional.encargadosAsist');
    }
}