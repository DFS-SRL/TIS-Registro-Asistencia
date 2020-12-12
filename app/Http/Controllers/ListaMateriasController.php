<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Materia;
class ListaMateriasController extends Controller
{
    public function mostrarMaterias($unidadId){
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
        $unidad = Unidad::where('id','=',$unidadId) -> select('nombre','facultad')->get();
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
