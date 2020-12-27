<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facultad;
use App\Unidad;
use App\Helpers\FechasPartesMensualesHelper;
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
        $facultades = Facultad::orderBy('nombre')->paginate(10);
        return view('informacion.listaFacultades',['facultades'=>$facultades]);
    }

    //Obtener la lista de todos los departamentos de la universidad
    public function listaTodosDepartamentos() {
        $departamentos = Unidad::orderBy('nombre')->paginate(10);
        return view('informacion.listaDepartamentos', ['departamentos'=>$departamentos]);
    }

    //Obtener la lista de departamentos pertenecientes a una facultad  
    public function listaDepartamentos(Facultad $facultad){
        $rolesPermitidos = [5];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos);
        if ($accesoOtorgado) {
            $departamentos = Unidad::where('facultad_id','=',$facultad->id)->orderBy('nombre')
                        ->join('Parte_mensual', function ($join){
                            $join->on('Unidad.id', '=', 'Parte_mensual.unidad_id')
                                ->orderBy('fecha_ini','desc')
                                ->limit(1);
                        })
                        ->paginate(5);
                        
            $departamentos = FechasPartesMensualesHelper::añadirMesPartes($departamentos);
            return view('informacion.listaDepartamentosFac',
            [
                'departamentos'=>$departamentos,
                'facultad'=>$facultad
            ]);
        }else{
            $rolesPermitidos = [4,6,7];
            $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos);
            if($accesoOtorgado){
                $departamentos = Unidad::where('facultad_id','=',$facultad->id)->orderBy('nombre')
                            ->join('Parte_mensual', function ($join){
                                $join->on('Unidad.id', '=', 'Parte_mensual.unidad_id')
                                    ->where('Parte_mensual.encargado_fac','=',true)
                                    ->orderBy('fecha_ini','desc')
                                    ->limit(1);
                            })
                            ->paginate(5);
                            
                $departamentos = FechasPartesMensualesHelper::añadirMesPartes($departamentos);
                return view('informacion.listaDepartamentosFac',
                [
                    'departamentos'=>$departamentos,
                    'facultad'=>$facultad
                ]);
            }

        }
        //Jefe DPA
        $rolesPermitidos = [8];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos);
        if ($accesoOtorgado) {
            $departamentos = Unidad::where('facultad_id','=',$facultad->id)->orderBy('nombre')
                        ->join('Parte_mensual', function ($join){
                            $join->on('Unidad.id', '=', 'Parte_mensual.unidad_id')
                                ->orderBy('fecha_ini','desc')
                                ->where('aprobado','=',true)
                                ->limit(1);
                        })
                        ->paginate(5);
            $departamentos = FechasPartesMensualesHelper::añadirMesPartes($departamentos);

            return view('informacion.listaDepartamentosDPA',
            [
            'departamentos'=>$departamentos,
            'facultad'=>$facultad
            ]);
        }else{
            return view('provicional.noAutorizado');
        }

        
        //Vista DPA
        

    }
}
