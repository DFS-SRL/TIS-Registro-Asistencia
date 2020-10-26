<?php

namespace App\Http\Controllers;

use App\Unidad;
use App\Asistencia;
use Illuminate\Http\Request;

class InformesController extends Controller
{
    // muestra la vista al jefe de departamento para acceder a informes semanales
    public function index(Unidad $unidad)
    {
        return view('informes.index',[
            'unidad' => $unidad
        ]);
    }
    
    // sube de nivel a las asistencias de los informes
    public function subirInformes()
    {
        calcularFechasMes(request()['fecha'], $t, $fechaInicio, $fechaFin);
        $asistencias = Asistencia::where('fecha', '>=', $fechaInicio)->where('fecha', '<=', $fechaFin)->where('unidad_id', '=', request()['unidad_id'])->select('Asistencia.*')->get();
        foreach ($asistencias as $key => $asistencia) {
            if($asistencia->nivel != 2)
                return 'no se pueden enviar :\'v';
        }
        foreach ($asistencias as $key => $asistencia) {
            $asistencia -> update([
                'nivel' => 3,
            ]);
        }
        return 'enviado correctamente :)';
    }
}