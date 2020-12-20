<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Grupo;
use App\UsuarioTieneRol;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriaController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function mostrarInformacion(Materia $materia) {
        // Obtener gupos de la materia
        $rolesPermitidos = [4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $materia->unidad_id);

        if(!$accesoOtorgado){
            return view('provicional.noAutorizado');
        }
        
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
