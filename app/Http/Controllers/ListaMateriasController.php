<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Materia;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;
use Illuminate\Validation\ValidationException;

class ListaMateriasController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function mostrarMaterias($unidadId){
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $unidadId);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        $unidad = Unidad::where('id','=',$unidadId) -> select('nombre','facultad_id')->get();
        $materias = Materia::where('unidad_id', '=', $unidadId) 
                            ->where('es_materia', '=', true)
                            -> select('nombre', 'id') 
                            -> orderBy('nombre')
                            -> paginate(10);
        return view('informacion.listaMaterias',[
            'unidad' => $unidad[0],
            'materias' => $materias
        ]);
    }

    public function mostrarCargosDeLaboratorio($unidadId) {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [4];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $unidadId);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        $unidad = Unidad::where('id','=',$unidadId) -> select('nombre','facultad_id')->get();
        $materias = Materia::where('unidad_id', '=', $unidadId)
        ->where('es_materia', '=', false)
        -> select('nombre', 'id')
        -> orderBy('nombre')
        -> paginate(10);
        return view('informacion.listaCargos',[
        'unidad' => $unidad[0],
        'cargos' => $materias
        ]);
    }
}
