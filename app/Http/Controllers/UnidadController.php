<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Facultad;
use App\Asistencia;
use App\ParteMensual;
use App\User;
use App\Helpers\FechasPartesMensualesHelper;
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
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('ver partes mensuales')
                        & Auth::user()->usuario->perteneceAUnidad($unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        return view('parteMensual.seleccion', ['unidad' => $unidad]);
    }
    //Obtener informacion de un departamento y la lista de sus ultimos 5 partes mensuales
    public function informacionDepartamento(Unidad $unidad){
        // Al jefe de dpa se le mostraran solo los partes que ya fueron aprobados
        // Los demas usuarios podran ver los partes si tienen el permiso
        if (Auth::user()->usuario->tienePermisoNombre('ver solo partes completos')) {
            $ultimosPartes = ParteMensual::where('unidad_id','=',$unidad->id)
                                          ->where('aprobado','=',true)
                                          ->orderBy('fecha_ini','desc')->limit(5)->get();
    
            $ultimosPartes = FechasPartesMensualesHelper::añadirMesPartes($ultimosPartes);
            return view('informacion.departamentoDPA', ['unidad' => $unidad, 'ultimosPartes'=>$ultimosPartes]);
        }
        $ultimosPartes = ParteMensual::where('unidad_id','=',$unidad->id)
                                        ->orderBy('fecha_ini','desc')->limit(5)->get();

        $ultimosPartes = FechasPartesMensualesHelper::añadirMesPartes($ultimosPartes);
        return view('informacion.departamentoFac', ['unidad' => $unidad, 'ultimosPartes'=>$ultimosPartes]);
    }
}
