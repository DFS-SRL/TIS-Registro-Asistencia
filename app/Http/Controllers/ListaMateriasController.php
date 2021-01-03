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

    public function mostrarMaterias( $unidadId){
        $unidad = Unidad::where('id','=',$unidadId) -> select('id','nombre','facultad_id')->get();
        $materias = Materia::where('unidad_id', '=', $unidadId) 
                            ->where('es_materia', '=', true)
                            ->where('activo', '=',true)
                            -> select('nombre', 'id') 
                            -> orderBy('nombre')
                            -> paginate(10);
        return view('informacion.listaMaterias',[
            'unidad' => $unidad[0],
            'materias' => $materias
        ]);
    }
    public function editarListaMaterias($unidadId){
        $unidad = Unidad::where('id','=',$unidadId) -> select('id','nombre','facultad_id')->get();
        $materias = Materia::where('unidad_id', '=', $unidadId) 
                            ->where('es_materia', '=', true)
                            ->where('activo', '=',true)
                            -> select('nombre', 'id') 
                            -> orderBy('nombre')
                            -> get();
        return view('informacion.editar.editarListaMaterias',[
            'unidad' => $unidad[0],
            'materias' => $materias
        ]);
    }
    public function mostrarCargosDeLaboratorio($unidadId) {
        $unidad = Unidad::where('id','=',$unidadId) -> select('nombre','facultad_id','id')->get();
        $materias = Materia::where('unidad_id', '=', $unidadId)
        ->where('es_materia', '=', false)
        ->where('activo', '=',true)
        -> select('nombre', 'id')
        -> orderBy('nombre')
        -> paginate(10);
        return view('informacion.listaCargos',[
        'unidad' => $unidad[0],
        'cargos' => $materias
        ]);
    }
    public function editarListaCargosDeLabo($unidadId) {
        $unidad = Unidad::where('id','=',$unidadId) -> select('nombre','facultad_id','id')->get();
        $materias = Materia::where('unidad_id', '=', $unidadId)
        ->where('es_materia', '=', false)
        ->where('activo', '=',true)
        -> select('nombre', 'id')
        -> orderBy('nombre')
        ->get();
        return view('informacion.editar.editarListaCargos',[
        'unidad' => $unidad[0],
        'cargos' => $materias
        ]);
    }
}
