<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facultad;
use App\Unidad;
use App\Helpers\FechasPartesMensualesHelper;

class FacultadController extends Controller
{
    //
    //Obtener lista de todas las facultades que estan registradas paginadas en 10
    public function listaFacultades(){
        $facultades = Facultad::orderBy('nombre')->paginate(10);
        return view('informacion.listaFacultades',['facultades'=>$facultades]);
    }
    //Obtener la lista de departamentos pertenecientes a una facultad  
    public function listaDepartamentos(Facultad $facultad){
        // $rolesPermitidos = [4,5];
        // $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos, $unidad->id);
        // if (!$accesoOtorgado) {
        //     return view('provicional.noAutorizado');
        // }
        //Vista Facultativo
        $departamentos = Unidad::where('facultad_id','=',$facultad->id)->orderBy('nombre')
                                ->join('Parte_mensual', function ($join){
                                    $join->on('Unidad.id', '=', 'Parte_mensual.unidad_id')
                                         ->orderBy('fecha_ini','desc')
                                         ->limit(1);
                                })
                                ->paginate(5);
                                
        $departamentos = FechasPartesMensualesHelper::añadirMesPartes($departamentos);
        // return view('informacion.listaDepartamentosFac',
        //         [
        //             'departamentos'=>$departamentos,
        //             'facultad'=>$facultad
        //         ]);
        //Vista DPA
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

    }
}
