<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Grupo;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function mostrarInformacion(Materia $materia) {
        // Obtener gupos de la materia
        $grupos = Grupo::where('materia_id', '=', $materia->id)
                            ->get();
        
        return [$materia, $grupos];
    }
}
