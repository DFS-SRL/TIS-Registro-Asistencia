<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facultad;
use App\ParteMensual;
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
        $rolesPermitidos = [8];
        $accesoOtorgado = UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos);
        if (!$accesoOtorgado) {
        }
        $facultades = Facultad::orderBy('nombre')
                            ->where('activo','=',true)
                            ->paginate(10);
        return view('informacion.listaFacultades',['facultades'=>$facultades]);
    }

    //Obtener la lista de todos los departamentos de la universidad
    public function listaTodosDepartamentos() {
        $departamentos = Unidad::orderBy('nombre')->paginate(10);
        return view('informacion.listaDepartamentos', ['departamentos'=>$departamentos]);
    }

    //Obtener la lista de departamentos pertenecientes a una facultad  
    public function listaDepartamentos(Facultad $facultad){
        $rolesPermitidos = [4,5,6,7];
        $rolAceptado = true;//UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos);
            
        //Falta restringir acceso por facultades (los miembros de otra facultad distinta a la ingresada solo ven los
        //                                        partes aprobados)
        $usuarioPerteneceFacultad = PersonalAcademicoController::perteneceAFacultad(Auth::user()->usuario->codSis, $facultad->id);
        if ($rolAceptado&&$usuarioPerteneceFacultad) {            
            $departamentos = Unidad::where('facultad_id','=',$facultad->id)->where('activo',true)->orderBy('nombre');
            $mesesPartes = ParteMensual::orderBy('fecha_ini','desc')
                                        ->joinSub($departamentos,'departamentos',function($join){
                                            $join->on('departamentos.id', '=', 'unidad_id');
                                        })
                                        ->select('fecha_ini')
                                        ->distinct()
                                        ->paginate(5);
        }else{
            $rolesPermitidos = [4,5,6,7,8];//esto por que es para otras facultades y para DPA
            $accesoOtorgado = true;//UsuarioTieneRol::alMenosUnRol(Auth::user()->usuario->codSis, $rolesPermitidos);
            if($accesoOtorgado){
                $departamentos = Unidad::where('facultad_id','=',$facultad->id)->where('activo',true)->orderBy('nombre');
                $mesesPartes = ParteMensual::where('aprobado','=',true)//es esta linea la que cambia
                                            ->orderBy('fecha_ini','desc')
                                            ->joinSub($departamentos,'departamentos',function($join){
                                                $join->on('departamentos.id', '=', 'unidad_id');
                                            })
                                            ->select('fecha_ini')
                                            ->distinct()
                                            ->paginate(5);
            }else{
                return view('provicional.noAutorizado');
            }

        }
 
        $mesesPartes = FechasPartesMensualesHelper::añadirMesPartes($mesesPartes);
        $mesesPartes = FechasPartesMensualesHelper::separarAño($mesesPartes);
        return view('informacion.facultad',
        [
            'departamentos'=>$departamentos->paginate(5),
            'facultad'=>$facultad,
            'mesesPartes'=>$mesesPartes
        ]);    
    }
    public function editarListaFacultades(){
        $facultades = Facultad::orderBy('nombre')
                                ->where('activo','=',true)
                                ->get();
        return view('informacion.editar.editarListaFacultades',['facultades'=>$facultades]); 
    }
    public function eliminarFacultad(Facultad $facultad){

        $facultad->update(['activo' => false]);
        return back()->with('success', 'Facultad eliminada');
    }
    public function guardarFacultad(Request $facultad){
        Facultad::insert(["nombre"=>$facultad->nombre,"activo"=>$facultad->activo,"encargado_codSis"=>$facultad->encargado_codSis,"decano_codSis"=>$facultad->decano_codSis,"director_codSis"=>$facultad->director_codSis]);
        $facultad = Facultad::where("nombre",$facultad->nombre)    
                                ->where("activo",$facultad->activo)
                                ->where("encargado_codSis",$facultad->encargado_codSis)
                                ->where("decano_codSis",$facultad->decano_codSis)
                                ->where("director_codSis",$facultad->director_codSis)
                                ->first();
        UsuarioTieneRol::insert(["usuario_codSis"=>$facultad->encargado_codSis,"rol_id"=>5,"facultad_id"=>$facultad->id ]);
        UsuarioTieneRol::insert(["usuario_codSis"=>$facultad->decano_codSis,"rol_id"=>6,"facultad_id"=>$facultad->id]);
        UsuarioTieneRol::insert(["usuario_codSis"=>$facultad->director_codSis,"rol_id"=>7,"facultad_id"=>$facultad->id]);
        return back()->with('success', 'Facultad guardada');
    }

}
