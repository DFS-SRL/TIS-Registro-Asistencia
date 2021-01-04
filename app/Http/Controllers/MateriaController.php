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
        $grupos = Grupo::where('materia_id', '=', $materia->id)
                        ->where('activo','=',true)
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
    public function editarListaGrupos(Materia $materia){
        $grupos = Grupo::where('materia_id', '=', $materia->id)
                        ->where('activo','=',true)
                        ->get();
        
        if ($materia->es_materia) {
            return view('informacion.editar.editarMateria', [
                "materia" => $materia,
                "grupos" => $grupos
            ]);
        } else {
            return view('informacion.editar.editarCargo', [
                "cargo" => $materia,
                "items" => $grupos
            ]);
        }
    }
    public function eliminarMateria(Materia $materia){
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                | Auth::user()->usuario->tienePermisoNombre('editar item/cargo');
        if (!$acceso) {
            return view('provicional.noAutorizado');
        }
        
        $materia->update(['activo' => false]);
        if($materia->es_materia){
            return back()->with('success', 'Materia eliminada');
        }
        return back()->with('success', 'Cargo eliminado');
    }
    public function guardarMateria(Request $materia){
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                | Auth::user()->usuario->tienePermisoNombre('editar item/cargo');
        if (!$acceso) {
            return view('provicional.noAutorizado');
        }
        Materia::insert(["unidad_id"=>$materia->unidad_id,"nombre"=>$materia->nombre,"es_materia"=>$materia->es_materia,"activo"=>$materia->activo]);
        if($materia->es_materia == "true"){
            return back()->with('success', 'Materia guardada');
        }
        return back()->with('success', 'Cargo guardado');
        
    }
    
}
