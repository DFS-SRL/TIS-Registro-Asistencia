@extends('layouts.master')

@section('title', 'Informe mensual de asistencia')

@section('css')
    <style>
        .esquina-redondeada {
            border-style: solid;
            border-radius: 25px;
            padding: 20px;
            border-color: black;
        }
        .espaciado {
            margin-bottom: 30px;
            margin-top: 30px;
        }
    </style>
@endsection

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h2 class = "textoBlanco" >INFORME MENSUAL DE ASISTENCIA DE AUXILIAR</h2>
                    <h4 class="textoBlanco">FACULTAD: {{ $unidad->facultad->nombre }}</h4>
                    <h4 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h4>
                    <h4 class="textoBlanco">NOMBRE: 
                        <a href="{{ route('informacion.auxiliar', ['unidad' => $unidad->id, 'usuario' => $usuario->codSis]) }}">
                            {{ $usuario->nombre() }}
                        </a>
                    </h4>
                    <h4 class="textoBlanco">CODIGO SIS: {{ $usuario->codSis }}</h4>
                    <br>
                </div>
                <div class="col-4">
                    <b class="textoBlanco">DEL: </b><span class="textoBlanco"> {{ $fechaInicio }}</span>
                    <b class="textoBlanco ml-4">AL: </b><span class="textoBlanco"> {{ $fechaFinal }}</span>

                    <div class="row textoBlanco justify-content-center esquina-redondeada espaciado" style="background:#7C7365;">
                        <div class="col-12 opciones">
                            <input type="radio" id="todo" name="informe" value="docencia" checked="checked" onclick="tablas()">
                            <label for="todo">Todo</label><br>
                            <input type="radio" id="auxDoc" name="informe" value="aux-docencia" onclick="tablas()">
                            <label for="auxDoc">Asistencias Aux. de Docencia</label><br>
                            <input type="radio" id="auxLabo" name="informe" value="laboratorio" onclick="tablas()">
                            <label for="auxLabo">Asistencias Aux. de Laboratorio</label>
                        </div>
                    </div>


                </div>
            </div>

            <br>
            <div id="table-todos">
                @if (!$asistencias->isEmpty())
                    {{-- <h4 class="textoBlanco">{{ $unidad[0]->unidad->facultad }} /
                        {{ $unidad[0]->unidad->nombre }}</h4> --}}
                    <table class="table table-responsive">
                        <tr>
                            <th class="textoBlanco border border-dark">MATERIA/CARGO</th>
                            <th class="textoBlanco border border-dark">GRUPO/ÍTEM   </th>
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
                                        @if($asistencia->asistencia)
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
        
                @else
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h4 class="text-center textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
        
                @endif
            </div>
            <div id="table-doc">
                @if (!$asistenciasDoc->isEmpty())
                    {{-- <h4 class="textoBlanco">{{ $unidad[0]->unidad->facultad }} /
                        {{ $unidad[0]->unidad->nombre }}</h4> --}}
                    <table class="table table-responsive">
                        <caption class="textoNegro mostaza" style="caption-side: top;">ASISTENCIAS AUX. DE DOCENCIA</caption>
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
                        @foreach ($asistenciasDoc as $asistencia)
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
                                        <div class="col-12">
                                            <button type="button" class="btn btn-success boton">
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
                                @if (auth()->user()->usuario->codSis == $unidad->facultad->encargado_codSis)
                                    <td class = "border border-dark">
                                        @if($asistencia->asistencia)
                                            <button class="btn boton" onclick="confirmarInvalidarAsistencia({{ $asistencia->id }});">INVALIDAR</button>
                                        @endif
                                    </td>    
                                @endif
                            </tr>
                        @endforeach
                    </table>
        
                @else
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h4 class="text-center textoBlanco">NO HAY ASISTENCIAS DE AUX. DE DOCENCIA REGISTRADAS</h4>
        
                @endif
            </div>

            <div id="table-labo">
                @if (!$asistenciasLabo->isEmpty())
                    {{-- <h4 class="textoBlanco">{{ $unidad[0]->unidad->facultad }} /
                        {{ $unidad[0]->unidad->nombre }}</h4> --}}
                    <table class="table table-responsive">
                        <caption class="textoNegro mostaza" style="caption-side: top;">ASISTENCIAS AUX. DE LABORATORIO</caption>
                        <tr>
                            <th class="textoBlanco border border-dark">CARGO</th>
                            <th class="textoBlanco border border-dark">ITEM</th>
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
                        @foreach ($asistenciasLabo as $asistencia)
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
                                        <div class="col-12">
                                            <button type="button" class="btn btn-success boton">
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
                                @if (auth()->user()->usuario->codSis == $unidad->facultad->encargado_codSis)
                                    <td class = "border border-dark">
                                        @if($asistencia->asistencia)
                                            <button class="btn boton" onclick="confirmarInvalidarAsistencia({{ $asistencia->id }});">INVALIDAR</button>
                                        @endif
                                    </td>    
                                @endif
                            </tr>
                        @endforeach
                    </table>
        
                @else
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <h4 class="text-center textoBlanco">NO HAY ASISTENCIAS DE AUX. DE LABO. REGISTRADAS</h4>
        
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
    <script src="/js/informes/mensual.js"></script>
    <script>
        // var a = @json($asistencias);
        // console.log(a);

        var todo = $('#todo');
        var auxDoc = $('#auxDoc');
        var auxLabo = $('#auxLabo');
        var table_todos = $('#table-todos');
        var table_doc = $('#table-doc');
        var table_labo = $('#table-labo');

        tablas();
        
        function tablas(){
            if(todo.is(':checked')){
                console.log('Funciona');
                if(table_todos.hasClass('d-none')){
                    table_todos.removeClass('d-none');
                }
                if(!table_doc.hasClass('d-none')){
                    table_doc.addClass('d-none');
                }
                if(!table_labo.hasClass('d-none')){
                    table_labo.addClass('d-none');
                }
            }else if(auxDoc.is(':checked')){
                if(!table_todos.hasClass('d-none')){
                    table_todos.addClass('d-none');
                }
                if(table_doc.hasClass('d-none')){
                    table_doc.removeClass('d-none');
                }
                if(!table_labo.hasClass('d-none')){
                    table_labo.addClass('d-none');
                }
            }else if(auxLabo.is(':checked')){
                if(!table_todos.hasClass('d-none')){
                    table_todos.addClass('d-none');
                }
                if(!table_doc.hasClass('d-none')){
                    table_doc.addClass('d-none');
                }
                if(table_labo.hasClass('d-none')){
                    table_labo.removeClass('d-none');
                }
            }
        }

    </script>
@endsection
