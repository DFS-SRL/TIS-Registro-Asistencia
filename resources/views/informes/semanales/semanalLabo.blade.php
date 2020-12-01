@extends('layouts.master')

@section('title', 'Auxiliares laboratorios')

@section('css')
    <style>
        table, th, td {
        border: 1px solid black;
        }
    </style>
@endsection

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">            
                <div class="col-8"> 
                    <h2 class = "textoBlanco" >PLANILLA SEMANAL DE ASISTENCIA AUXILIARES DE LABORATORIO</h2>
                    <h4 class="textoBlanco">FACULTAD: {{ $unidad['facultad'] }}</h4>
                    <h4 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h4>
                    <br>
                </div>
                <div class = "col-4">
                    <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
                    <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFinal}}</span>
                </div>
            </div>
            @if (!$asistencias->isEmpty())
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th class = "textoBlanco border border-dark" scope="col">CARGO</th>
                        <th class = "textoBlanco border border-dark" scope="col">ITEM</th>
                        <th class = "textoBlanco border border-dark" scope="col">NOMBRE</th>
                        <th class = "textoBlanco border border-dark" scope="col">CODIGO SIS</th>
                        <th class = "textoBlanco border border-dark" scope="col">FECHA</th>
                        <th class = "textoBlanco border border-dark" scope="col">HORARIO</th>
                        <th class = "textoBlanco border border-dark" scope="col">ACTIVIDAD REALIZADA</th>
                        <th class = "textoBlanco border border-dark" scope="col">OBSERVACIONES</th>
                        <th class = "textoBlanco border border-dark" scope="col">ASISTENCIA</th>
                        <th class = "textoBlanco border border-dark" scope="col">PERMISO</th>
                    </tr>
                    @foreach ($asistencias as $asistencia)
                        <tr>
                            <td class = "border border-dark">
                                <a href="{{ route('cargo.informacion', $asistencia->materia_id ) }}">
                                    {{ $asistencia->materia->nombre }} 
                                </a>
                            </td>
                            <td class = "border border-dark">
                                <a href="{{ route('item.informacion', $asistencia->grupo_id) }}">
                                    {{ $asistencia->grupo->nombre }} 
                                </a>
                            </td>
                            <td class = "border border-dark">
                                <a href="{{ route('informacion.auxiliar', ['unidad' => $unidad->id, 'usuario' => $asistencia->usuario_codSis]) }}">
                                    {{ $asistencia->usuario->nombre() }}
                                </a>
                            </td>
                            <td class = "border border-dark">{{ $asistencia->usuario->codSis }}</td>
                            <td class = "border border-dark">{{ formatoFecha($asistencia->fecha) }} </td>
                            <td class = "border border-dark">{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }}</td>
                            <td class = "border border-dark">{{ $asistencia->actividad_realizada }}</td>
                            <td class = "border border-dark">{{ $asistencia->observaciones }}</td>
                            <td class = "border border-dark">{{ $asistencia->asistencia ? 'SI' : 'NO' }}</td>
                            <td class = "border border-dark">{{ $asistencia->permiso ? $asistencia->permiso : '' }}</td>   
                        </tr>
                    @endforeach 
                </table>  
            @else
            <br>
            <br>
            <br>
            <br>
            <br>    
                <h4 class="text-center textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
            @endif
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/informes/semanalLabo.js"></script>
@endsection