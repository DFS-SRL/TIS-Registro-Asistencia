<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Unidad;
use App\Facultad;
use App\Asistencia;
use App\ParteMensual;
use App\User;
use App\Helpers\FechasPartesMensualesHelper;
use App\HorarioClase;
use App\Mail\NotifiacionPlanillaDiaria;
use App\Mail\NotificacionPlanillaSemanal;
use App\Notificaciones;
use App\Usuario;
use App\UsuarioPerteneceUnidad;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\UsuarioTieneRol;
use FontLib\TrueType\Collection;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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


        //Aqui falta añadir lo de departamentos Activos
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




        $horarios = HorarioClase::
            where('Horario_clase.unidad_id', '=', $unidad->id)
            ->where('activo', '=', true)
            ->get()->groupBy('dia');
        
        // fecha por dias de la semana
        $fechaPorDia = getFechasDeSemanaEnFecha("today");

        $personal = [];

        // buscar horarios que no fueron registrados
        foreach ($horarios as $horariosEnDia) {
            foreach ($horariosEnDia as $falta) {
                $asistencia = Asistencia::where('horario_clase_id', '=', $falta->id)
                ->where('fecha', '=', $fechaPorDia[compararDias($falta->dia, "LUNES")])
                ->get();
                $codSis = $falta->asignado_codSis;
                if ($asistencia->isEmpty() && $codSis !== null) {
                    // array_push($personal, $falta);
                    // array_push($personal, collect(['codSis' => $codSis, 'horario' => $falta, 'asistencia' => $asistencia]));
                    array_push($personal, $codSis);
                }
            }
        }

        $count = array_count_values($personal);
        
        $faltas = [];

        foreach($count as $c){
            array_unshift($faltas, $c);
        }
    
        $count = array_unique($personal);

        $personal = [];
        foreach($count as $c){
            array_push($personal, collect([
                'usuario' => Usuario::where('codSis', '=', $c)->get()[0],
                'faltas' => array_pop($faltas),
                // 'total' => HorarioClase::
                // select(DB::raw('count(*)'))
                // ->where('unidad_id', '=', $unidad->id)
                // ->where('asignado_codSis', '=', $c)
                // ->groupBy('asignado_codSis')
                // ->get()

            ]));
        }

        usort($personal, function($a, $b){
            return strcmp($a['usuario']->nombre, $b['usuario']->nombre);
        });

        return view('informacion.departamentoFac', ['unidad' => $unidad, 'ultimosPartes'=>$ultimosPartes, 'personal' => paginate($personal, 10)]);
    }

    public function notificar(Request $request){
        // $unidad = Unidad::find($request->unidad);
        $personal = Usuario::find($request->personal);
        // $jefe = Usuario::find($request->jefe);

        $docente = PersonalAcademicoController::esDocente($request->personal, $request->unidad);
        $auxDoc  = PersonalAcademicoController::esAuxDoc($request->personal, $request->unidad);
        $auxLabo = PersonalAcademicoController::esAuxLab($request->personal, $request->unidad);

        $type = $auxDoc ? "auxdoc" : "docente";

        if($docente || $auxDoc){
            Mail::to($personal->correo_electronico)->send(new NotificacionPlanillaSemanal($personal, $type));
            Notificaciones::create([
                'user_id' => $personal->codSis,
                'text' => 'Llena tus planillas semanales ' . ($auxDoc ? 'de auxiliatura de docencia.' : 'de docencia.'),
                'link' => route('planillas.semanal.' . $type, $personal->codSis)
            ]);
        }
        
        if($auxLabo){
            Mail::to($personal->correo_electronico)->send(new NotifiacionPlanillaDiaria($personal));
            Notificaciones::create([
                'user_id' => $personal->codSis,
                'text' => 'Llena tus planillas semanales de auxiliatura de laboratorio.',
                'link' => route('planillas.diaria.obtener', $personal->codSis)
            ]);
        }

        return back()->with('success', 'Se ha enviado una notificación al personal ' . $personal->nombre);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        // $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        // $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function editarListaDepartamentos(Facultad $facultad){
        $departamentos = Unidad::where('facultad_id','=',$facultad->id)->where('activo',true)->orderBy('nombre');
        return view('informacion.editar.editarListaDepartamentos',
        [
            'departamentos'=>$departamentos->get(),
            'facultad'=>$facultad
        ]); 
    }
    public function eliminarDepartamento(Unidad $unidad){

        $unidad->update(['activo' => false]);
        return back()->with('success', 'Departamento eliminado');
    }
    public function guardarDepartamento(Request $unidad){
        Unidad::insert(["nombre"=>$unidad->nombre,"activo"=>$unidad->activo,"jefe_codSis"=>$unidad->jefe_codSis,"facultad_id"=>$unidad->facultad_id]);
        $unidad = Unidad::where("nombre",$unidad->nombre)    
                                ->where("activo",$unidad->activo)
                                ->where("jefe_codSis",$unidad->jefe_codSis)
                                ->where("facultad_id",$unidad->facultad_id)
                                ->first();
        UsuarioTieneRol::insert(["usuario_codSis"=>$unidad->jefe_codSis,"rol_id"=>4,"departamento_id"=>$unidad->id ]);
        UsuarioPerteneceUnidad::insert([
            "usuario_codSis" => $unidad->jefe_codSis,
            "unidad_id" => $unidad->id,
            "jefe_dept" => 'true'
        ]);
        return back()->with('success', 'Departamento guardado');
    }
}
