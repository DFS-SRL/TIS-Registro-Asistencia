<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;
use App\Permiso;
use App\UsuarioTienePermiso;

class AdministracionPermisosController extends Controller
{
    public function listaDeUsuarios() {
        return view('administracion.listaDeUsuarios', ['usuarios' => Usuario::orderBy('nombre')->paginate(10)]);
    }

    public function vistaDePermisos(Usuario $usuario) {
        $todosLosPermisos = Permiso::all();
        $permisosUsuario = $usuario->todosLosPermisos();
        foreach ($todosLosPermisos as &$permiso) {
            $tienePermiso = false;
            foreach ($permisosUsuario as $perUsuario ) {
                if ($perUsuario->id == $permiso->id) $tienePermiso = true;
            }
            $permiso['tiene'] = $tienePermiso;
        }
        return view('administracion.asignarPermisos', ['usuario' => $usuario, 'todosLosPermisos' => $todosLosPermisos]);
    }

    public function actualizarPermisos(Usuario $usuario, Request $request) {
        $permisosNuevos;
        foreach ($request->all() as $key => $value) {
            if ($key != '_token') $permisosNuevos[$key] = $value;
        }
        $permisosAntiguos = UsuarioTienePermiso::where('usuario_codsis', $usuario->codSis);
        $permisosAntiguos->delete();

        foreach ($permisosNuevos as $key => $value) {
            $nuevo = new UsuarioTienePermiso;
            $nuevo->permiso_id = $key;
            $nuevo->usuario_codsis = $usuario->codSis;
            $nuevo->save();
        }
        return back();
    }
}
