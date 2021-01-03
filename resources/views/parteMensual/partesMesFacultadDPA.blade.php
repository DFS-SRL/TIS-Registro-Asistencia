@extends('layouts.master')

@section('title', 'Lista de Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
                <h3 class="textoBlanco">FACULTAD: {{ $facultad->nombre }}</h3>
                <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3> 
                <br> 
                <h3 class="textoBlanco"> {{strtoupper($mes)}}  </h3>  
                
            <div class="container mt-4">
                <table class="table ">
                    
                @if (!$departamentos->isEmpty())
                        <tr>                            
                            <th class="textoBlanco border border-dark" scope="col">DEPARTAMENTO</th>
                            <th class="textoBlanco border border-dark" scope="col">PARTES MENSUALES</th>
                        </tr>
                        @foreach ($departamentos as $departamento)
                            <tr class="">
                                <td class="border border-dark align-middle"><a
                                    href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a></td>
                                    @if ($departamento->parteID!=null)
                                        <td class="border border-dark align-middle ">
                                            <a href="/parteMensual/auxiliares/{{ $departamento->id}}/{{aumentarMes($departamento->fecha_ini)}}">Ver parte auxiliares</a>
                                            <a href="/parteMensual/docentes/{{ $departamento->id}}/{{aumentarMes($departamento->fecha_ini)}}">Ver parte docentes</a>                                        
                                        </td>
                                    @else
                                        <td class="border border-dark ">NO HAY PARTES MENSUALES DISPONIBLES </td>
                                    @endif
                                    </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <h3 class="textoBlanco">ESTA FACULTAD AUN NO TIENE REGISTRADO PARTES MENSUALES</h3>
                @endif
            </div>
        </div>
    </div>
@endsection
