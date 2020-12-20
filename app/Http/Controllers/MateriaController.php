<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Grupo;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;

class MateriaController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }		

    public function mostrarInformacion(Materia $materia) {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, null);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        // Obtener gupos de la materia
        $grupos = Grupo::where('materia_id', '=', $materia->id)
                            ->get();
        
        if ($materia->es_materia) {
            return view('informacion.materia', [
                "materia" => $materia,
                "grupos" => $grupos
            ]);
        } else {
            return view('informacion.cargo', [
                "cargo" => $materia,
                "items" => $grupos
            ]);
        }
    }
}
