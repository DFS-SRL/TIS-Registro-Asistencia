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
    public function eliminarMateria(Materia $materia){
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        $materia->update(['activo' => false]);
        return back()->with('success', 'Materia eliminada');
    }
    public function guardarMateria(Materia $materia){
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        $materia = Materia::where('id', '=', $materia->id);
        return back()->with('success', 'Materia guardada');
    }
    public function eliminarCargo(Materia $cargo){
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar item/cargo');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        $cargo->update(['activo' => false]);
        return back()->with('success', 'Cargo de laboratorio eliminado');
    }
    public function guardarCargo(Materia $cargo){
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar item/cargo');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        $cargo = Materia::where('id', '=', $cargo->id);
        return back()->with('success', 'Cargo de laboratorio guardado');
    }
}
