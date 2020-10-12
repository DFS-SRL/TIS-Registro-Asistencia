<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormularioAuxiliarDocenciaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $departamentos = [
            ['title' => 'Departamento #1'],
            ['title' => 'Departamento #2'],
            ['title' => 'Departamento #3'],
        ];

        $materias = [
            [
                'departamento'  => 'Departamento #1',
                'horario'       => '12:45 - 14:15',
                'grupo'         => '1',
                'materia'       => 'Algebra',
            ] ,
            [
                'departamento' => 'Departamento #2',
                'horario'       => '12:45 - 14:15',
                'grupo'         => '2',
                'materia'       => 'Algebra',
            ] ,
            [
                'departamento' => 'Departamento #3',
                'horario'       => '12:45 - 14:15',
                'grupo'         => '3',
                'materia'       => 'Algebra',
            ] ,
            [
                'departamento' => 'Departamento #3',
                'horario'       => '12:45 - 14:15',
                'grupo'         => '3',
                'materia'       => 'Algebra',
            ] 
        ];

        return view('auxiliar_docencia.formulario', compact('departamentos'), compact('materias'));
    }
}
