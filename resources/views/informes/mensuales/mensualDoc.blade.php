@extends('layouts.master')

@section('title', 'Informe mensual de asistencia')

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h2 class = "textoBlanco" >INFORME MENSUAL DE ASISTENCIA DE DOCENTE</h2>
                    <h4 class="textoBlanco">FACULTAD: {{ $unidad->facultad->nombre }}</h4>
                    <h4 class="textoBlanco">DEPARTAMENTO: {{ $unidad->nombre }} </h4>
                    <h4 class="textoBlanco">NOMBRE: 
                        <a href="{{ route('informacion.docente', ['unidad' => $unidad->id, 'usuario' => $usuario->codSis]) }}">
                            {{ $usuario->nombre() }}
                        </a>
                    </h4>
                    <h4 class="textoBlanco">CODIGO SIS: {{ $usuario->codSis }}</h4>
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
                <table class="table table-responsive">
                    <tr>
                        <th class="textoBlanco border border-dark">MATERIA</th>
                        <th class="textoBlanco border border-dark">GRUPO</th>
                        <th class="textoBlanco border border-dark">FECHA</th>
                        <th class="textoBlanco border border-dark">HORARIO</th>
                        <th class="textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
                        <th class="textoBlanco border border-dark">INDICADOR VERIFICABLE</th>
                        <th class="textoBlanco border border-dark">OBSERVACIONES</th>
                        <th class="textoBlanco border border-dark">ASISTENCIA</th>
                        <th class="textoBlanco border border-dark">PERMISO</th>
                        @if(auth()->user()->usuario->codSis == $unidad->facultad->encargado_codSis)
                            <th class="textoBlanco border border-dark">OPCIONES</th>
                        @endIf
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
                            <td class = "border border-dark">{{ formatoFecha($asistencia->fecha) }}</td>
                            <td class = "border border-dark">{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }} </td>
                            <td class = "border border-dark">{{ $asistencia->actividad_realizada }} </td>
                            <td class = "border border-dark">{{ $asistencia->indicador_verificable }} </td>
                            <td class = "border border-dark">{{ $asistencia->observaciones }}</td>
                            <td class = "border border-dark"> {{ $asistencia->asistencia ? 'SI' : 'NO' }}</td>
                            {{-- <td class = "border border-dark"> {{ $asistencia->permiso ? $asistencia->permiso : '' }} </td> --}}
                            @if ( $asistencia->permiso )
                                <td class = "border border-dark">
                                    @if ( $asistencia->documento_adicional != null )
                                        <div class="col-12">
                                            <form id="doc{{$asistencia->id}}" action="{{ route('descargarArchivo', $asistencia->documento_adicional) }}">
                                                @csrf
                                                <button type="button" class="btn btn-success boton" onclick="document.getElementById('doc{{$asistencia->id}}').submit();" >
                                                    <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                        <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                        <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <?=str_replace('_', ' ', $asistencia->permiso)?>
                                    </div>
                                </td>
                            @else
                                <td class = "border border-dark"></td>
                            @endif
                            @if (auth()->user()->usuario->codSis == $unidad->facultad->encargado_codSis)
                                <td class = "border border-dark">
                                    @if($asistencia->asistencia || $asistencia->permiso != null || $asistencia->permiso != '')
                                        <button class="btn boton" onclick="confirmarInvalidarAsistencia({{ $asistencia->id }});">INVALIDAR</button>
                                        <form id="invalidar{{ $asistencia->id }}" method="POST" action="{{ route('asistencia.invalidar', $asistencia) }}" class="d-none">
                                            @csrf @method('PATCH')
                                        </form>
                                    @endif
                                </td>    
                            @endif
                            
                        </tr>
                    @endforeach
                </table>
                <div class="mt-2 d-flex justify-content-center">
                    {{ $asistencias->links() }}
                </div>
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
    <script src="/js/informes/mensual.js"></script>
    <script>
        var a = @json($asistencias);
        console.log(a);
    </script>
@endsection
