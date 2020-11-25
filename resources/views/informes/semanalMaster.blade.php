@extends('layouts.master')

@section('title', 'Planilla semanal de asistencia')

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h2 class = "textoBlanco" >INFORMES SEMANAL DE ASISTENCIA @yield('tipo_academico')</h2>
                    <h4 class="textoBlanco">FACULTAD: {{ $unidad['facultad'] }}</h4>
                    <h4 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h4>
                    <br>
                </div>
                <div class="col-4">
                    <b class="textoBlanco">DEL: </b><span class="textoBlanco"> {{ $fechaInicio }}</span>
                    <b class="textoBlanco ml-4">AL: </b><span class="textoBlanco"> {{ $fechaFinal }}</span>
                </div>
            </div>
            <br>
    
            @if (!$asistencias->isEmpty())
                {{-- <h4 class="textoBlanco">{{ $unidad[0]->unidad->facultad }} /
                    {{ $unidad[0]->unidad->nombre }}</h4> --}}
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th class="textoBlanco border border-dark">MATERIA</th>
                        <th class="textoBlanco border border-dark">GRUPO</th>
                        <th class="textoBlanco border border-dark">NOMBRE</th>
                        <th class="textoBlanco border border-dark">CODIGO SIS</th>
                        <th class="textoBlanco border border-dark">FECHA</th>
                        <th class="textoBlanco border border-dark">HORARIO</th>
                        <th class="textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
                        <th class="textoBlanco border border-dark">INDICADOR VERIFICABLE</th>
                        <th class="textoBlanco border border-dark">OBSERVACIONES</th>
                        <th class="textoBlanco border border-dark">ASISTENCIA</th>
                        <th class="textoBlanco border border-dark">PERMISO</th>
                    </tr>
                    @foreach ($asistencias as $asistencia)
                        <tr>
                            <td class = "border border-dark">
                                <a href="{{ route('materia.informacion', $asistencia->materia_id ) }}">
                                    {{ $asistencia->materia->nombre }} 
                                </a>
                            </td>
                            <td class = "border border-dark">
                                <a href="{{ route('grupo.informacion', $asistencia->grupo_id) }}">
                                    {{ $asistencia->grupo->nombre }} 
                                </a>
                            </td>
                            <td class = "border border-dark">
                                <a href="{{ route('informacion.' . ($asistencia->horarioClase->rol_id == 3 ? 'docente' : 'auxiliar'), ['unidad' => $unidad->id, 'usuario' => $asistencia->usuario_codSis]) }}">
                                    {{ $asistencia->usuario->nombre }}
                                </a>
                            </td>
                            <td class = "border border-dark">{{ $asistencia->usuario->codSis }} </td>
                            <td class = "border border-dark">{{ formatoFecha($asistencia->fecha) }}</td>
                            <td class = "border border-dark">{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }} </td>
                            <td class = "border border-dark">{{ $asistencia->actividad_realizada }} </td>
                            <td class = "border border-dark">{{ $asistencia->indicador_verificable }} </td>
                            <td class = "border border-dark">{{ $asistencia->observaciones }}</td>
                            <td class = "border border-dark"> {{ $asistencia->asistencia ? 'SI' : 'NO' }}</td>
                            <td class = "border border-dark"> {{ $asistencia->permiso ? $asistencia->permiso : '' }} </td>
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
    <script src="/js/main.js"></script>
@endsection
