<?php

namespace App\Http\Controllers;

use App\Rol;
use App\Grupo;
use App\Usuario;
use App\HorarioClase;
use App\UsuarioTieneRol;
use App\Materia;
use Illuminate\Http\Request;
use App\Http\Requests\UsuarioGrupoRequest;
use App\Http\Controllers\PersonalAcademicoController;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class GrupoController extends Controller
{
    use AuthenticatesUsers;
    
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Las clases de docencia y auxiliatura son Materia en la BD
     * Tanto los grupos como los items son Grupo en la BD
     */

    public function eliminarGrupo(Grupo $grupo){
        // return $grupo;
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                | Auth::user()->usuario->tienePermisoNombre('editar item/cargo');
        if (!$acceso || !Auth::user()->usuario->perteneceAUnidad($grupo->unidad_id)) {
            return view('provicional.noAutorizado');
        }

        $grupo->update(['activo' => false]);
        if($grupo->materia->es_materia){
            return back()->with('success', 'grupo eliminado');
        }
        return back()->with('success', 'Item eliminado');
    }
    public function guardarGrupo(Request $grupo){
        // return $grupo;
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                | Auth::user()->usuario->tienePermisoNombre('editar item/cargo');
        if (!$acceso || !Auth::user()->usuario->perteneceAUnidad($grupo->unidad_id)) {
            return view('provicional.noAutorizado');
        }

        Grupo::insert(["unidad_id"=>$grupo->unidad_id,"nombre"=>$grupo->nombre,"materia_id"=>$grupo->materia_id,"activo"=>$grupo->activo]);
        $es_materia = Materia::where("id",'=',$grupo->materia_id)->get();
        // return $es_materia;
        if($es_materia[0]->es_materia){
            return back()->with('success', 'Grupo guardado');
        }
        return back()->with('success', 'Item guardado');
    }

    private function informacionGrupo(Grupo $grupo)
    {
        //* Obtener horarios y personal es igual para docencia y laboratorio

        // Obtener los horarios correspondientes a la materia
        $horarios = HorarioClase::where('grupo_id', '=', $grupo->id)
            ->where('activo', '=', 'true')
            ->get();

        $horarios = $horarios->sort(function (HorarioClase $a, HorarioClase $b) {
            $diffDias = compararDias($a->dia, $b->dia);
            if ($diffDias === 0) {
                return ($a->hora_inicio < $b->hora_inicio ? -1 : 1);
            } else {
                return $diffDias;
            }
        })->values();

        //* IMPORTANTE
        //* Se asume que cada grupo tiene asignado maximo un docente y un auxiliar

        // Obtiene el docente asignado al grupo
        $docente = Usuario::join('Usuario_tiene_rol', 'Usuario_tiene_rol.usuario_codSis', '=', 'codSis')
            ->join('Rol', 'Rol.id', '=', 'Usuario_tiene_rol.rol_id')
            ->where('Rol.id', '=', 3)
            ->join('Horario_clase', 'Horario_clase.asignado_codSis', '=', 'codSis')
            ->where('activo', '=', 'true')
            ->where('Horario_clase.grupo_id', '=', $grupo->id)
            ->select('Usuario.codSis', 'Usuario.nombre')
            ->get()->first();

        // Obtiene el auxiliar asignado al grupo
        $auxiliar = Usuario::join('Usuario_tiene_rol', 'Usuario_tiene_rol.usuario_codSis', '=', 'codSis')
            ->join('Rol', 'Rol.id', '=', 'Usuario_tiene_rol.rol_id')
            ->where('Rol.id', '<=', 2)
            ->join('Horario_clase', 'Horario_clase.asignado_codSis', '=', 'codSis')
            ->where('activo', '=', 'true')
            ->where('Horario_clase.grupo_id', '=', $grupo->id)
            ->select('Usuario.codSis', 'Usuario.nombre')
            ->get()->first();

        // Se calcula la carga horaria
        // 45 minutos por hora pagable para docencia y 60 minutos para laboratorios
        $cargaHorariaDocente = 0;
        $cargaHorariaAuxiliar = 0;
        foreach ($horarios as $horario) {
            if ($docente != null && $horario->asignado_codSis == $docente->codSis) {
                $cargaHorariaDocente += tiempoHora($horario->hora_inicio)
                    ->diffInMinutes(tiempoHora($horario->hora_fin))
                    / 45;
            }
            if ($auxiliar != null && $horario->asignado_codSis == $auxiliar->codSis) {
                $cargaHorariaAuxiliar += tiempoHora($horario->hora_inicio)
                    ->diffInMinutes(tiempoHora($horario->hora_fin))
                    / ($horario->rol_id == 2 ? 45 : 60);
            }
        }

        //* Ahora diferenciamos entre docencia y auxiliaruta
        $esGrupoDeDocencia = $grupo->materia->es_materia;

        if ($esGrupoDeDocencia) {
            return [
                'esGrupoDeDocencia' => $esGrupoDeDocencia,
                'grupo' => $grupo,
                'horarios' => $horarios,
                'docente' => $docente,
                'auxiliar' => $auxiliar,
                'cargaHorariaDocente' => $cargaHorariaDocente,
                'cargaHorariaAuxiliar' => $cargaHorariaAuxiliar
            ];
        } else {
            return [
                'esGrupoDeDocencia' => $esGrupoDeDocencia,
                'item' => $grupo,
                'horarios' => $horarios,
                'auxiliar' => $auxiliar,
                'cargaHorariaAuxiliar' => $cargaHorariaAuxiliar
            ];
        }
    }
    //Esta funcion se usa al momento de entrar a la vista de grupo
    public function mostrarInformacion(Grupo $grupo)
    {
        $informacion = $this->informacionGrupo($grupo);
        if ($informacion['esGrupoDeDocencia']) {
            return view('informacion.grupo', $informacion);
        } else {
            abort(404);
        }
    }
    //Esta funcion se usa al momento de entrar a la vista de item
    public function mostrarInformacionItem(Grupo $grupo)
    {
        $informacion = $this->informacionGrupo($grupo);
        if ($informacion['esGrupoDeDocencia']) {
            abort(404);
        } else {
            return view('informacion.item', $informacion);
        }
    }
    //Esta funcion se usa al momento de entrar a la vista de editar grupo
    public function editarInformacion(Grupo $grupo)
    {
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                & Auth::user()->usuario->perteneceAUnidad($grupo->unidad->id);
        if(!$acceso){
            return view('/provicional/noAutorizado');
        }
        $informacion = $this->informacionGrupo($grupo);
        if ($informacion['esGrupoDeDocencia']) {
            return view('informacion.editar.editarGrupo', $informacion);
        } else {
            abort(404);
        }
    }
    //Esta funcion se usa al momento de entrar a la vista de editar item
    public function editarInformacionItem(Grupo $grupo)
    {
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar item/cargo')
                        & Auth::user()->usuario->perteneceAUnidad($grupo->unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        $informacion = $this->informacionGrupo($grupo);
        if ($informacion['esGrupoDeDocencia']) {
            abort(404);
        } else {
            return view('informacion.editar.editarItem', $informacion);
        }
    }

    // funcion para preguntar si un codsis es de docente y devuelve la vista de edicion del grupo
    public function esDocente(Grupo $grupo, Request $request)
    {
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                & Auth::user()->usuario->perteneceAUnidad($grupo->unidad->id);
        if(!$acceso){
            return view('/provicional/noAutorizado');
        }
        $informacion = $this->informacionGrupo($grupo);
        $informacion['asignarDocente'] = true;
        $usuario = null;
        if (PersonalAcademicoController::esDocente($request['codSis'], $grupo->unidad_id))
            $usuario = Usuario::find($request['codSis']);
        $informacion['usuario'] = $usuario;

        return view('informacion.editar.editarGrupo', $informacion);
    }


    // funcion para preguntar si un codsis es de docente y devuelve la vista de edicion del grupo
    public function esAuxDoc(Grupo $grupo, Request $request)
    {
        $acceso = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                & Auth::user()->usuario->perteneceAUnidad($grupo->unidad->id);
        if(!$acceso){
            return view('/provicional/noAutorizado');
        }
        $informacion = $this->informacionGrupo($grupo);
        $informacion['asignarAuxiliar'] = true;
        $usuario = null;
        if (PersonalAcademicoController::esAuxDoc($request['codSis'], $grupo->unidad_id))
            $usuario = Usuario::find($request['codSis']);
        $informacion['usuario'] = $usuario;
        return view('informacion.editar.editarGrupo', $informacion);
    }

    // asignar docente a un grupo
    public function asignarDocente(UsuarioGrupoRequest $request)
    {
        // return $request;
        $datos = $request->validated();

        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                        & Auth::user()->usuario->perteneceAUnidad(Grupo::find($datos['grupo_id'])->unidad_id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        if (!PersonalAcademicoController::esDocente($datos['codSis'], Grupo::find($datos['grupo_id'])->unidad_id)) {
            $error = ValidationException::withMessages([
                'codSis' => ['el codigo sis no pertenece a un docente de la unidad']
            ]);
            throw $error;
        }
        return $this->asignarUsuarioRol($datos['codSis'], $datos['grupo_id'], 3);
    }

    // asignar docente a un grupo
    public function asignarAuxDoc(UsuarioGrupoRequest $request)
    {
        $datos = $request->validated();
        
        // Verificamos que el usuario tiene los roles permitidos
        $rolesPermitidos = [4];
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                        & Auth::user()->usuario->perteneceAUnidad(Grupo::find($datos['grupo_id'])->unidad_id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        if (!PersonalAcademicoController::esAuxDoc($datos['codSis'], Grupo::find($datos['grupo_id'])->unidad_id)) {
            $error = ValidationException::withMessages([
                'codSis' => ['el codigo sis no pertenece a un auxiliar de docencia de la unidad']
            ]);
            throw $error;
        }
        return $this->asignarUsuarioRol($datos['codSis'], $datos['grupo_id'], 2);
    }
    public function asignarAuxLabo(UsuarioGrupoRequest $request)
    {
        $datos = $request->validated();
        
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar item/cargo')
                        & Auth::user()->usuario->perteneceAUnidad(Grupo::find($datos['grupo_id'])->unidad_id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        if (!PersonalAcademicoController::esAuxLab($datos['codSis'], Grupo::find($datos['grupo_id'])->unidad_id)) {
            $error = ValidationException::withMessages([
                'codSis' => ['el codigo sis no pertenece a un auxiliar de laboratorio de la unidad']
            ]);
            throw $error;
        }
        return $this->asignarUsuarioRol($datos['codSis'], $datos['grupo_id'], 1);
    }
    // funcion auxiliar para asignar personal con codSis y rol a los horarios de un grupo
    private function asignarUsuarioRol($codSis, $grupo_id, $rol_id)
    {
        $horarios = HorarioClase::where('grupo_id', '=', $grupo_id)
            ->where('rol_id', '=', $rol_id)
            ->where('activo', '=', 'true')
            ->get();
        foreach ($horarios as $horario) {
            $horario->update([
                'asignado_codSis' => $codSis
            ]);
        }
        return back()->with('success', 'Registro exitoso');
    }

    // designar docente a un grupo
    public function desasignarDocente(Grupo $grupo)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                        & Auth::user()->usuario->perteneceAUnidad($grupo->unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        return $this->desasignarUsuarioRol($grupo->id, 3);
    }
    public function desasignarAuxiliar(Grupo $grupo)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar grupo/materia')
                        & Auth::user()->usuario->perteneceAUnidad($grupo->unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        return $this->desasignarUsuarioRol($grupo->id, 2);
    }
    public function desasignarAuxiliarDeLaboratorio(Grupo $grupo)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('editar item/cargo')
                        & Auth::user()->usuario->perteneceAUnidad($grupo->unidad->id);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }
        
        return $this->desasignarUsuarioRol($grupo->id, 1);
    }

    // funcion auxiliar para asignar personal con codSis y rol a los horarios de un grupo
    private function desasignarUsuarioRol($grupo_id, $rol_id)
    {
        $this->asignarUsuarioRol(null, $grupo_id, $rol_id);
        return back()->with('success', 'Personal desasignado');
    }
}