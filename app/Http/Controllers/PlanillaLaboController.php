<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Usuario;
use App\Planilla;
use App\Asistencia;
use App\HorarioClase;
use App\UsuarioTieneRol;
use Illuminate\Http\Request;
use App\helpers\AsistenciaHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\RegistrarAsistenciaLaboRequest;

class PlanillaLaboController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function obtenerPlanillaDia(Usuario $user)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('llenar planilla diaria')
            & (Auth::user()->usuario->codSis == $user->codSis);
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        // obteniendo horarios asignados en el dia actual
        $horarios =  HorarioClase::where('asignado_codSis', '=', $user->codSis)
            ->where('activo', '=', 'true')
            ->where('rol_id', '=', 1)
            ->where('dia', '=', getDia())
            ->orderBy('hora_inicio', 'ASC')
            ->get();

        // obteniendo planillas guardadas
        $planillas =  Planilla::join('Horario_clase', 'id', '=', 'horario_clase_id')
            ->where('asignado_codSis', '=', $user->codSis)
            ->where('activo', '=', 'true')
            ->where('rol_id', '=', 1)
            ->where('dia', '=', getDia())
            ->select('Planilla.*')
            ->get();

        // ver si no se lleno la planilla de esta semana
        $registradas = $this->asistenciasRegistradas($user, 1);
        $llenado = $registradas->count() == $horarios->count() && $horarios->count() > 0;

        foreach ($horarios as $key => $horario) {
            if ($registradas->contains('id', $horario->id)) {
                $horarios->forget($key);
            }
        }

        // devolver vista de planillas diarias
        return view('planillas.diaria', [
            'usuario' => $user,
            'fecha' => getFecha(),
            'horarios' => $horarios,
            'planillas' => $planillas,
            'llenado' => $llenado
        ]);
    }

    public function registrarAsistencia(RegistrarAsistenciaLaboRequest $request)
    {
        // Verificamos que el usuario tiene los roles permitidos
        $accesoOtorgado = Auth::user()->usuario->tienePermisoNombre('llenar planilla diaria');
        if (!$accesoOtorgado) {
            return view('provicional.noAutorizado');
        }

        // validar
        $asistencias = array_values($request->validated()['asistencias']);

        // ver si no se lleno la planilla de hoy
        $usuario = Usuario::find(HorarioClase::find($asistencias[0]['horario_clase_id'])->asignado_codSis);

        // validar que la asistencia es del usuario que envia el formulario
        if ($usuario->codSis != Auth::user()->usuario->codSis) {
            return view('provicional.noAutorizado');
        }

        $registradas = $this->asistenciasRegistradas($usuario);
        if ($registradas->count() == $this->cuantosHorarios($usuario)) {
            $error = ValidationException::withMessages([
                'lleno' => ['LA PLANILLA YA FUE LLENADA']
            ]);
            throw $error;
        }


        // recorrer asistencias colocando datos extra y almacenando en bd
        foreach ($asistencias as $key => $asistencia) {
            if ($registradas->contains('id', $asistencia['horario_clase_id']))
                continue;
            $horario = HorarioClase::find($asistencia['horario_clase_id']);
            $asistencia['fecha'] = getFechaF("Y-m-d");
            $asistencia['nivel'] = 2;
            $asistencia['usuario_codSis'] = $horario->asignado_codSis;
            $asistencia['materia_id'] = $horario->materia_id;
            $asistencia['grupo_id'] = $horario->grupo_id;
            $asistencia['unidad_id'] = $horario->unidad_id;

            if (array_key_exists('documento_adicional', $asistencia)) {
                $doc = $asistencia['documento_adicional'];
                $docNombre = pathInfo($doc->getClientOriginalName(), PATHINFO_FILENAME);
                $docExtension = $doc->getClientOriginalExtension();
                $nombreAGuardar = $docNombre . '_' . time() . '.' . $docExtension;
                $path = $doc->storeAs('documentosAdicionales', $nombreAGuardar);
                $asistencia['documento_adicional'] = $nombreAGuardar;
            }

            // eliminar planillas guardadas
            $planilla = Planilla::find($asistencia['horario_clase_id']);
            if ($planilla != null)
                $planilla->delete();

            Asistencia::create($asistencia);
        }

        return back()->with('success', "asistencias registradas!!!");
    }

    private function asistenciasRegistradas($usuario)
    {
        return Asistencia::where('fecha', '=', date('Y-m-d'))
            ->join('Horario_clase', 'Horario_clase.id', '=', 'horario_clase_id')
            ->where('rol_id', '=', 1)
            ->where('Horario_clase.asignado_codSis', '=', $usuario->codSis)
            ->select('Horario_clase.id')
            ->get();
    }

    private function cuantosHorarios($usuario)
    {
        return HorarioClase::where('asignado_codSis', '=', $usuario->codSis)
            ->where('activo', '=', 'true')
            ->where('rol_id', '=', 1)
            ->where('dia', '=', getDia())
            ->count();
    }
}