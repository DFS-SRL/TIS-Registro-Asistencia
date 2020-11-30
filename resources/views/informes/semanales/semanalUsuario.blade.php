@extends('layouts.master')

@section('title', 'Informe semanal de Asistencia')

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h2 class = "textoBlanco">INFORME SEMANAL DE ASISTENCIA</h2>
                </div>
                <div class = "col-6">
                    <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
                    <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFinal}}</span>
                </div>
            </div>
            <h4 class = "textoBlanco">USUARIO: {{ $usuario->nombre() }}</h4>
            <h4 class = "textoBlanco">CODIGO SIS: {{ $usuario->codSis }}</h4>
            @if(!$asistencias->isEmpty())
                @foreach ($asistencias as $key1 => $unidad)
                    <br>
                    <h4 class = "textoBlanco">{{$unidad[0]->unidad->facultad}} / {{$unidad[0]->unidad->nombre}}</h4>
                        @csrf
                        <table class = "table table-responsive">
                            <tr>
                                <th class = "textoBlanco border border-dark">@if($esDocente)MATERIA @else MATERIA/CARGO @endif</th>
                                <th class = "textoBlanco border border-dark">@if($esDocente)GRUPO @else GRUPO/ÍTEM @endif</th>
                                <th class = "textoBlanco border border-dark">FECHA</th>
                                <th class = "textoBlanco border border-dark">HORARIO</th>
                                <th class = "textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
                                <th class = "textoBlanco border border-dark">INDICADOR VERIFICABLE</th>
                                <th class = "textoBlanco border border-dark">OBSERVACIONES</th>
                                <th class = "textoBlanco border border-dark">ASISTENCIA</th>
                                <th class = "textoBlanco border border-dark">PERMISO</th>
                                <th class = "textoBlanco border border-dark">OPCIONES</th>
                            </tr>
                            @foreach ($unidad as $key2 => $asistencia)
                                <tr>
                                    <td class = "border border-dark">{{ $asistencia->materia->nombre }}</td>
                                    <td class = "border border-dark">{{ $asistencia->grupo->nombre }}</td>
                                    <td class = "border border-dark">{{ formatoFecha($asistencia->fecha) }}</td>
                                    <td class = "border border-dark">{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }} </td>
                                    <td class = "border border-dark">{{ $asistencia->actividad_realizada }} </td>
                                    <td class = "border border-dark">{{ $asistencia->indicador_verificable }} </td>
                                    <td class = "border border-dark">{{ $asistencia->observaciones }}</td>
                                    <td class = "border border-dark"> {{ $asistencia->asistencia ? 'SI' : 'NO' }}</td>
                                    {{-- <td class = "border border-dark"> {{ $asistencia->permiso ? $asistencia->permiso : '' }} </td> --}}
                                    @if ( $asistencia->permiso )
                                        <td class = "border border-dark">
                                            <div class="col-12">
                                                <button type="button" class="btn btn-success boton" >
                                                    <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                        <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                        <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="text-center">
                                                <?=str_replace('_', ' ', $asistencia->permiso)?>
                                            </div>
                                        </td>
                                    @else
                                        <td class = "border border-dark"></td>
                                    @endif
                                    <td class="border border-dark">
                                        <input 
                                            id = {{"botonEditar".$asistencia->id}}
                                            width="30rem"
                                            height="30rem"
                                            type="image"
                                            name="botonEditar" 
                                            src="/icons/editar.png" 
                                            alt="Editar"
                                            onclick="camposEdicionAsitencia({{$asistencia->id}}, {{$asistencia}}); desactivar()"
                                        >
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                @endforeach 
            @else
                <br>
                <br>
                <br>
                <br>
                <br>
                <h4 class="text-center textoBlanco">
                    NO HAY ASISTENCIAS REGISTRADAS
                </h4>
        
            @endif
            <button class="btn boton float-right" id="registrar" style="display:none;">REGISTRAR</button>  
            </form>      
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
@endsection