<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use Carbon\Carbon;
use App\Asistencia;
use App\HorarioClase;
use App\UsuarioTieneRol;
use Illuminate\Http\Request;
use App\helpers\BuscadorHelper;
use App\UsuarioPerteneceUnidad;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

class PersonalAcademicoController extends Controller
{
    // devuelve la vista de todo el personal academico de la unidad correspondiente
    public function obtenerPersonal(Unidad $unidad, $codigos = null)
    {
        $todos = Usuario::join('Usuario_pertenece_unidad', 'codSis', '=', 'usuario_codSis')
            ->where('unidad_id', '=', $unidad->id)->select(
                'Usuario.nombre',
                'Usuario.codSis'
            );
        if (is_array($codigos)) {
            $raw = 'case';
            foreach ($codigos as $key => $codSis) {
                $raw .= ' when "Usuario"."codSis"=' . $codSis . ' then ' . $key;
            }
            $raw .= ' end';
            $todos = $todos->whereIn('codSis', $codigos)
                ->orderByRaw($raw);
        } else
            $todos = $todos->orderBy('nombre', 'asc');
        $todos = $todos->paginate(10, ['*'], 'todos-pag');
        foreach ($todos as $key => $usuario) {
            $usuario->roles = UsuarioTieneRol::where('usuario_codSis', '=', $usuario->codSis)
                ->where('rol_id', '>=', 1)
                ->where('rol_id', '<=', 3)
                ->join('Rol', 'Rol.id', '=', 'rol_id')
                ->select('nombre')
                ->get();
        }
        $docentes = $this->obtenerUsuariosRol($unidad, 3, $codigos);
        $auxiliaresDoc = $this->obtenerUsuariosRol($unidad, 2, $codigos);
        $auxiliaresLabo = $this->obtenerUsuariosRol($unidad, 1, $codigos);
        return view('personal.listaPersonal', [
            'unidad' => $unidad,
            'todos' => $todos,
            'docentes' => $docentes,
            'auxDoc' => $auxiliaresDoc,
            'auxLabo' => $auxiliaresLabo
        ]);
    }

    // busca coincidencias en los nombres del personal que pertenecen a cierta unidad academica
    public function buscarPersonal(Unidad $unidad, $buscando = null)
    {
        if (request()->method() == 'POST') {
            $datos = $this->validarBuscado();
            return redirect()->route('personalAcademico.buscando', [
                'unidad' => $unidad,
                'buscando' => $datos['buscado']
            ]);
        }
        request()['buscado'] = $buscando;
        $datos = $this->validarBuscado();
        $buscando =  BuscadorHelper::separar(BuscadorHelper::normalizar($datos['buscado']));
        $aux = Usuario::join('Usuario_pertenece_unidad', 'codSis', '=', 'usuario_codSis')
            ->where('unidad_id', '=', $unidad->id)
            ->get();
        $personal = [];
        foreach ($aux as $usuario) {
            $coincidencias = BuscadorHelper::coincidencias($usuario->nombre, $buscando);
            if ($coincidencias > 0.5) {
                $personal[$usuario->codSis] = ['val' => $coincidencias, 'nombre' => $usuario->nombre];
            }
        }
        uasort($personal, function ($a, $b) {
            if ($a['val'] == $b['val'])
                return $a['nombre'] < $b['nombre'] ? -1 : 1;
            return $a['val'] > $b['val'] ? -1 : 1;
        });
        $codigos = [];
        foreach ($personal as $key => $value) {
            array_push($codigos, $key);
        }
        request()->session()->flash('info', 'Resultados de la busqueda');
        return $this->obtenerPersonal($unidad, $codigos);
    }

    private function validarBuscado()
    {
        return request()->validate([
            'buscado' => ['required', 'regex:/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]*$/', 'max:50']
        ]);
    }

    // obtener usuarios con el rol indicado que pertenezcan a la unidad indicada
    private function obtenerUsuariosRol(Unidad $unidad, $rol, $codigos = null)
    {
        $usuarios = Usuario::join('Usuario_pertenece_unidad', 'codSis', '=', 'Usuario_pertenece_unidad.usuario_codSis')
            ->where('unidad_id', '=', $unidad->id)
            ->join('Usuario_tiene_rol', 'codSis', '=', 'Usuario_tiene_rol.usuario_codSis')
            ->where('rol_id', '=', $rol)
            ->select('Usuario.nombre', 'Usuario.codSis');
        if (is_array($codigos)) {
            $raw = 'case';
            foreach ($codigos as $key => $codSis) {
                $raw .= ' when "Usuario"."codSis"=' . $codSis . ' then ' . $key;
            }
            $raw .= ' end';
            $usuarios = $usuarios->whereIn('codSis', $codigos)
                ->orderByRaw($raw);
        } else
            $usuarios = $usuarios->orderBy('nombre', 'asc');
        return
            $usuarios->paginate(10, ['*'], 'usuario-' . $rol . '-pag');;
    }
    //devuelve los grupos en los que haya sido asignado el codsis, dependiendo si esta activo o si es materia
    private function buscarGruposAsignadosActuales($unidadId, $codSis, $esMateria)
    {
        return  HorarioClase::join('Usuario', 'Usuario.codSis', '=', "Horario_clase.asignado_codSis")
            ->join('Grupo', 'Grupo.id', '=', 'Horario_clase.grupo_id')
            ->join('Materia', 'Materia.id', '=', 'Horario_clase.materia_id')
            ->where('Grupo.unidad_id', '=', $unidadId)
            ->where('asignado_codSis', '=', $codSis)
            ->where('Materia.es_materia', $esMateria)
            ->where('activo', '=', 'true')
            ->distinct()
            ->select('Horario_clase.grupo_id', 'Materia.nombre AS nombre_materia', 'Materia.id AS materia_id', 'Grupo.nombre AS nombre_grupo')->get();
    }
    private function buscarGruposAsignadosPasados($unidadId, $codSis, $esMateria, $actuales)
    {
        return Asistencia::join('Usuario', 'Usuario.codSis', '=', "Asistencia.usuario_codSis")
            ->join('Grupo', 'Grupo.id', '=', 'Asistencia.grupo_id')
            ->join('Materia', 'Materia.id', '=', 'Asistencia.materia_id')
            ->where('Grupo.unidad_id', '=', $unidadId)
            ->whereNotIn('Asistencia.grupo_id', $actuales)
            ->where('usuario_codSis', '=', $codSis)
            ->where('Materia.es_materia', $esMateria)
            ->distinct()
            ->select('Asistencia.grupo_id', 'Materia.nombre AS nombre_materia', 'Materia.id AS materia_id', 'Grupo.nombre AS nombre_grupo')->get();
    }
    //devuelve la vista de la informacion del auxiliar
    public function informacionAuxiliar(Unidad $unidad, Usuario $usuario)
    {
        $this->validarUsuarioDeUnidad($unidad, $usuario, [1, 2]);
        $codSis = $usuario->codSis;
        $unidadId = $unidad->id;
        $gruposActuales = $this->buscarGruposAsignadosActuales($unidadId, $codSis, 'true');
        $gruposPasados = $this->buscarGruposAsignadosPasados($unidadId, $codSis, 'true', array_column($gruposActuales->toArray(), 'grupo_id'));

        $itemsActuales = $this->buscarGruposAsignadosActuales($unidadId, $codSis, 'false');
        $itemsPasados = $this->buscarGruposAsignadosPasados($unidadId, $codSis, 'false', array_column($itemsActuales->toArray(), 'grupo_id'));

        $asistencias = $this->asistenciasUsuarioUnidad($unidad, $usuario);

        return view('personal.informacionAuxiliar', [
            'unidad' => $unidad,
            'usuario' => $usuario,
            'cargaHorariaNominalGrupos' => $this->cargaHorariaNominal($unidad, $usuario, 2),
            'gruposActuales' => $gruposActuales,
            'gruposPasados' => $gruposPasados,
            'cargaHorariaNominalItems' => $this->cargaHorariaNominal($unidad, $usuario, 1),
            'itemsActuales' => $itemsActuales,
            'itemsPasados' => $itemsPasados,
            'asistencias' => $asistencias
        ]);
    }

    // devuelve la vista de la informacion del docente
    public function informacionDocente(Unidad $unidad, Usuario $usuario)
    {
        $this->validarUsuarioDeUnidad($unidad, $usuario, [3]);
        $codSis = $usuario->codSis;
        $gruposActuales = $this->buscarGruposAsignadosActuales($unidad->id, $codSis, 'true');
        $gruposPasados = $this->buscarGruposAsignadosPasados($unidad->id, $codSis, 'true', array_column($gruposActuales->toArray(), 'grupo_id'));
        $asistencias = $this->asistenciasUsuarioUnidad($unidad, $usuario);
        return view('personal.informacionDocente', [
            'unidad' => $unidad,
            'usuario' => $usuario,
            'cargaHorariaNominalGrupos' => $this->cargaHorariaNominal($unidad, $usuario, 3),
            'gruposActuales' => $gruposActuales,
            'gruposPasados' => $gruposPasados,
            'asistencias' => $asistencias
        ]);
    }

    // obtiene asistencias del usuario en la unidad ordenadas por tiempo en orden decreciente
    private function asistenciasUsuarioUnidad(Unidad $unidad, Usuario $usuario)
    {
        $asistencias = Asistencia::where('usuario_codSis', '=', $usuario->codSis)
            ->where('Asistencia.unidad_id', '=', $unidad->id)
            ->join('Horario_clase', 'Horario_clase.id', '=', 'Asistencia.horario_clase_id')
            ->orderBy('fecha', 'desc')
            ->orderBy('Horario_clase.hora_inicio', 'desc')
            ->select('Asistencia.*')
            ->get();
        // para que tambien se envie las informaciones de materia, grupo, usuario
        foreach ($asistencias as $asistencia) {
            $asistencia->horarioClase;
            $asistencia->materia;
            $asistencia->grupo;
            $asistencia->usuario;
        }
        return paginate($asistencias, 5);
    }

    // validar que el usuario pertenezca a la unidad y tenga los roles debidos
    private function validarUsuarioDeUnidad(Unidad $unidad, Usuario $usuario, $roles)
    {
        if (UsuarioPerteneceUnidad::where('Usuario_pertenece_unidad.usuario_codSis', '=', $usuario->codSis)
            ->where('unidad_id', '=', $unidad->id)
            ->join('Usuario_tiene_rol', 'Usuario_tiene_rol.usuario_codSis', '=', 'Usuario_pertenece_unidad.usuario_codSis')
            ->whereIn('rol_id', $roles)
            ->count() == 0
        ) {
            $error = ValidationException::withMessages([
                'usuario' => ['usuario invalido']
            ]);
            throw $error;
        }
    }

    // calcula la carga horaria nominal del usuario en la unidad segun el rol
    private function cargaHorariaNominal(Unidad $unidad, Usuario $usuario, $rol)
    {
        $horarios = HorarioClase::where('asignado_codSis', '=', $usuario->codSis)
            ->where('unidad_id', '=', $unidad->id)
            ->where('rol_id', '=', $rol)
            ->where('activo', '=', 'true')
            ->get();
        return $this->cargaHoraria($horarios, $rol == 1 ? 60 : 45);
    }

    // calcula carga horaria segun el periodo
    private function cargaHoraria($horarios, $periodo)
    {
        $carga = 0;
        foreach ($horarios as $horario) {
            $carga += tiempoHora($horario->hora_inicio)->diffInMinutes(tiempoHora($horario->hora_fin));
        }
        return $carga / $periodo;
    }

    // devuelve verdadero si el codSis es de un docente de la unidad_id
    public static function esDocente($codSis, $unidad_id)
    {
        return self::esDelRol($codSis, $unidad_id, 3);
    }

    // devuelve verdadero si el codSis es de un auxiliar de docencia de la unidad_id
    public static function esAuxDoc($codSis, $unidad_id)
    {
        return self::esDelRol($codSis, $unidad_id, 2);
    }

    // devuelve verdadero si el codSis es de un auxiliar de laboratorio de la unidad_id
    public static function esAuxLab($codSis, $unidad_id)
    {
        return self::esDelRol($codSis, $unidad_id, 1);
    }

    // devuelve verdadero si el codSis es de un axuliar de la unidad_id
    public static function esAuxiliar($codSis, $unidad_id)
    {
        return self::esAuxDoc($codSis, $unidad_id) || self::esAuxLab($codSis, $unidad_id);
    }

    // devuelve verdadero si el codSis es de un rol de la unidad_id
    private static function esDelRol($codSis, $unidad_id, $rol)
    {
        return !UsuarioTieneRol::where('rol_id', '=', $rol)
            ->where('Usuario_tiene_rol.usuario_codSis', '=', $codSis)
            ->join('Usuario_pertenece_unidad', 'Usuario_pertenece_unidad.usuario_codSis', '=', 'Usuario_tiene_rol.usuario_codSis')
            ->where('unidad_id', '=', $unidad_id)
            ->get()
            ->isEmpty();
    }

    //muestra la vista de registro de personal
    public function mostrarRegistro( Unidad $unidad){
        return view('personal.registrarPersonal',[
            'unidad' => $unidad,
            'despuesVerificar' => false,
            'personal' => [],
            'departamento' => []
        ]);
    }

    //verifica si existe el personal academico correspondiente al codsis en el departamento especificado o solo en el sistema o en ninguno
    public function verificarCodsis(Unidad $unidad){
        $codSis = request()->codsis;
        $personal = Usuario::where('codSis','=',$codSis)->get();
        $perteneceDepartamento = false;
        $nombres = "";
        $apellidoPaterno="";
        $apellidoMaterno="";
        $correo="";
        if(count($personal) != 0){
            $nombreSeparado = explode(" ",$personal[0]->nombre);
            $nombres = str_replace("_", " ", $nombreSeparado[2]);
            $apellidoPaterno = str_replace("_", " ", $nombreSeparado[0]);
            $apellidoMaterno = str_replace("_", " ", $nombreSeparado[1]);
            $correo = $personal[0]->correo_electronico;
            $perteneceDepartamento = !UsuarioPerteneceUnidad :: where('usuario_codSis','=',$codSis)
                ->where('unidad_id','=',$unidad->id)
                ->get()
                ->isEmpty();
        }
        $roles = [];
        if($perteneceDepartamento){
            request()->session()->flash('warning', 'El usuario especificado ya se encuentra registrado en este departamento, puede editar su informacion presionando el boton "EDITAR"');
            $rolesBD = UsuarioTieneRol::where('usuario_codSis','=',$codSis)->select('rol_id')->get();
            foreach($rolesBD as $rol){
                array_push($roles,$rol->rol_id);
            }
        }
        return view('personal.registrarPersonal',[
            'unidad'=>$unidad,
            'despuesVerificar'=>true,
            'nombres'=>$nombres,
            'apellidoPaterno'=>$apellidoPaterno,
            'apellidoMaterno'=>$apellidoMaterno,
            'correo'=>$correo,
            'perteneceDepartamento'=>$perteneceDepartamento,
            'codSis'=> $codSis,
            'roles'=>$roles
        ]);
    }
}