<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Asistencia;
use App\UsuarioTieneRol;
use Illuminate\Http\Request;
use App\helpers\BuscadorHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UsuarioController extends Controller
{
    // devuelve la vista de todo el personal academico de la unidad correspondiente
    public function obtenerPersonal(Unidad $unidad, $codigos = null)
    {
        //$codigos = Session::get('codigos');
        $todos = Usuario::join('Usuario_pertenece_unidad', 'codSis', '=', 'usuario_codSis')
            ->where('unidad_id', '=', $unidad->id)->select(
                'Usuario.nombre',
                'Usuario.codSis'
            );
        if ($codigos) {
            $raw = 'case';
            foreach ($codigos as $key => $codSis) {
                $raw .= ' when "Usuario"."codSis"=' . $codSis . ' then ' . $key;
            }
            $raw .= ' end';
            $todos = $todos->whereIn('codSis', $codigos)
                ->orderByRaw($raw);
        } else
            $todos = $todos->orderBy('nombre', 'asc');
        $todos = $todos->paginate(10);
        foreach ($todos as $key => $usuario) {
            $usuario->roles = UsuarioTieneRol::where('usuario_codSis', '=', $usuario->codSis)
                ->where('rol_id', '>=', 1)
                ->where('rol_id', '<=', 3)
                ->select('rol_id')
                ->get();
        }
        $docentes = $this->obtenerUsuariosRol($unidad, 3, $codigos);
        $auxiliaresDoc = $this->obtenerUsuariosRol($unidad, 2, $codigos);
        $auxiliaresLabo = $this->obtenerUsuariosRol($unidad, 1, $codigos);
        return view('personal.listaPersonal', [
            'unidad' => $unidad,
            'todos' => $todos,
            'docentes' => $docentes,
            'auxiliaresDoc' => $auxiliaresDoc,
            'auxiliaresLabo' => $auxiliaresLabo
        ]);
    }

    // busca coincidencias en los nombres del personal que pertenecen a cierta unidad academica
    public function buscarPersonal(Unidad $unidad)
    {
        $datos = request()->validate([
            'buscado' => ['required', 'regex:/^[a-zA-Z\s]*$/', 'max:50']
        ]);
        $buscando =  BuscadorHelper::separar(BuscadorHelper::normalizar($datos['buscado']));
        $aux = Usuario::join('Usuario_pertenece_unidad', 'codSis', '=', 'usuario_codSis')
            ->where('unidad_id', '=', $unidad->id)
            ->get();
        $personal = [];
        foreach ($aux as $usuario) {
            $coincidencias = BuscadorHelper::coincidencias(strtolower($usuario->nombre), $buscando);
            if ($coincidencias > 0.5) {
                $personal[$usuario->codSis] = $coincidencias;
            }
        }
        arsort($personal);
        $codigos = [];
        foreach ($personal as $key => $value) {
            array_push($codigos, $key);
        }
        request()->session()->flash('info', 'Resultados de la busqueda');
        //return redirect()->route('personalAcademico.obtenerPersonal', $unidad->id)->with(['codigos' => $codigos]);
        return $this->obtenerPersonal($unidad, $codigos);
    }

    // obtener usuarios con el rol indicado que pertenezcan a la unidad indicada
    private function obtenerUsuariosRol(Unidad $unidad, $rol, $codigos = null)
    {
        $usuarios = Usuario::join('Usuario_pertenece_unidad', 'codSis', '=', 'Usuario_pertenece_unidad.usuario_codSis')
            ->where('unidad_id', '=', $unidad->id)
            ->join('Usuario_tiene_rol', 'codSis', '=', 'Usuario_tiene_rol.usuario_codSis')
            ->where('rol_id', '=', $rol)
            ->select('Usuario.nombre', 'Usuario.codSis');
        if ($codigos) {
            $raw = 'case';
            foreach ($codigos as $key => $codSis) {
                $raw .= ' when "Usuario"."codSis"=' . $codSis . ' then ' . $key;
            }
            $raw .= ' end';
            $usuarios = $usuarios->whereIn('codSis', $codigos)
                ->orderByRaw($raw);
        } else
            $usuarios = $usuarios->orderBy('nombre', 'asc');
        return $usuarios->paginate(10);
    }

    public function informacionDocente(Unidad $unidad, Usuario $usuario)
    {
        $asistencias = Asistencia::where('usuario_codSis', '=', $usuario->codSis)
            ->where('unidad_id', '=', $unidad->id)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('personal.informacionDocente', [
            'asistencias' => $asistencias
        ]);
    }

    // paginar coleccion
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    // devuelve codSis si el codSis es de un docente de la unidad_id
    public static function esDocente($codSis, $unidad_id)
    {
        return self::esDelRol($codSis, $unidad_id, 3);
    }

    // devuelve codSis si el codSis es de un docente de la unidad_id
    public static function esAuxDoc($codSis, $unidad_id)
    {
        return self::esDelRol($codSis, $unidad_id, 2);
    }

    // devuelve codSis si el codSis es de un docente de la unidad_id
    public static function esAuxLab($codSis, $unidad_id)
    {
        return self::esDelRol($codSis, $unidad_id, 1);
    }

    // devuelve codSis si el codSis tiene el rol de la unidad_id
    private static function esDelRol($codSis, $unidad_id, $rol)
    {
        return !UsuarioTieneRol::where('rol_id', '=', $rol)->where('Usuario_tiene_rol.usuario_codSis', '=', $codSis)->join('Usuario_pertenece_unidad', 'Usuario_pertenece_unidad.usuario_codSis', '=', 'Usuario_tiene_rol.usuario_codSis')->where('unidad_id', '=', $unidad_id)->get()->isEmpty();
    }
}