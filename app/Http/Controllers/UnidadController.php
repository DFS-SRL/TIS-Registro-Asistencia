<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Facultad;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;

class UnidadController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    //obtener formulario para seleccionar parte mensual del departamento 
    public function obtenerParte(Unidad $unidad)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [4,5];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        return view('parteMensual.seleccion', ['unidad' => $unidad]);
    }
    //Obtener informacion de un departamento y la lista de sus ultimos 5 partes mensuales
    public function informacionDepartamento(Unidad $unidad){
        //Agregar lista de ultimos partes mensuales
        return view('informacion.departamento', ['unidad' => $unidad]);
    }
}
