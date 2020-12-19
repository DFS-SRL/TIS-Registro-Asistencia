<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facultad;
use App\Unidad;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;
use Illuminate\Validation\ValidationException;

class FacultadController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    //Obtener lista de todas las facultades que estan registradas paginadas en 10
    public function listaFacultades(){
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [5,6,7,8];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $unidadId);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        $facultades = Facultad::orderBy('nombre')->paginate(10);
        return view('informacion.listaFacultades',['facultades'=>$facultades]);
    }
    //Obtener la lista de departamentos pertenecientes a una facultad 
    public function listaDepartamentos(Facultad $facultad){
        $departamentos = Unidad::where('facultad_id','=',$facultad->id)->orderBy('nombre')->paginate(5);
        // return $departamentos;
        //Agregar lista de ultimos partes mensuales por departamento
        return view('informacion.listaDepartamentosFac',
                [
                    'departamentos'=>$departamentos,
                    'facultad'=>$facultad
                ]);
    }
}
