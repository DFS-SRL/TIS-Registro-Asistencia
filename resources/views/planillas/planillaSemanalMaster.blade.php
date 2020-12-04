@extends('layouts.master')

@section('title', 'Planilla Semanal de Asistencia')

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h2 class = "textoBlanco">PLANILLA SEMANAL DE ASISTENCIA</h2>
                </div>
                <div class = "col-6">
                    <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
                    <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFinal}}</span>
                </div>
            </div>
            <h4 class = "textoBlanco">@yield('tipoUsuario') {{ $usuario->nombre() }}</h4>
            <h4 class = "textoBlanco">CODIGO SIS: {{ $usuario->codSis }}</h4>
            @if(!$horarios->isEmpty())
                <form  method="POST"  @yield('action') @yield('onsubmit') enctype="multipart/form-data">
                    @foreach ($horarios as $key1 => $unidad)
                        <br>
                        <h4 class = "textoBlanco">{{$unidad[0]->unidad->facultad->nombre}} / {{$unidad[0]->unidad->nombre}}</h4>
                            @csrf
                            <table class = "table table-responsive">
                                <tr>
                                    <th class = "textoBlanco border border-dark">FECHA</th>
                                    <th class = "textoBlanco border border-dark">HORARIO</th>
                                    <th class = "textoBlanco border border-dark">GRUPO</th>
                                    <th class = "textoBlanco border border-dark">MATERIA</th>
                                    <th class = "textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
                                    <th class = "textoBlanco border border-dark">INDICADOR VERIFICABLE</th>
                                    <th class = "textoBlanco border border-dark">OBSERVACIONES</th>
                                    <th class = "textoBlanco border border-dark">ASISTENCIA</th>
                                    <th class = "textoBlanco border border-dark">PERMISO</th>
                                </tr>
                                @foreach ($unidad as $key2 => $horario)
                                    <tr>
                                        <td class="border border-dark">{{ $fechasDeSemana[$horario->dia] }}</td>
                                        <td class="border border-dark">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                                        <td class="border border-dark">{{ $horario->grupo->nombre }}</td>
                                        <td class="border border-dark">{{ $horario->materia->nombre }}</td>
                                        <td class="border border-dark">
                                            <textarea name="asistencias[{{ $key1.$key2 }}][actividad_realizada]" class ="{{$key1}}{{$key2}} actividad" 
                                            maxlength="150" id="actividad{{$key1.$key2 }}" onkeypress="valLim(150, 'actividad{{$key1.$key2}}', 'msgAct{{$key1.$key2}}')" onkeyup="valLim(150, 'actividad{{$key1.$key2}}', 'msgAct{{$key1.$key2}}')"  ></textarea>                             
                                            <label class ="text-danger" id="msgAct{{$key1.$key2 }}" for="actividad{{$key1.$key2 }}"></label>
                                        </td>
                                        <td class="border border-dark">
                                            <textarea name="asistencias[{{ $key1.$key2 }}][indicador_verificable]" class = "{{$key1}}{{$key2}}  verificable" id="verificable{{$key1.$key2 }}"></textarea>
                                            <label class ="text-danger" id="msgVer{{$key1.$key2 }}" for="verificable{{$key1.$key2 }}"></label>
                                        </td>
                                        <td class="border border-dark">
                                            <textarea name="asistencias[{{ $key1.$key2 }}][observaciones]" class = "{{$key1}}{{$key2}} observacion" maxlength="200" id="observacion{{$key1.$key2 }}" onkeypress="valLim(200, 'observacion{{$key1.$key2}}', 'msgObs{{$key1.$key2}}')" onkeyup="valLim(200, 'observacion{{$key1.$key2}}', 'msgObs{{$key1.$key2}}')" ></textarea>                            
                                            <label class ="text-danger" id="msgObs{{$key1.$key2 }}" for="observaciones"></label>
                                        </td>
                                        <td class="border border-dark">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="asistencia{{$key1}}{{$key2}}" onclick='habilitarDeshabilitar({{$key1.$key2}})' autocomplete="off" checked/>
                                                <label class="custom-control-label" for="asistencia{{$key1}}{{$key2}}"></label>
                                            </div>
                                        </td>
                                        <td class="border border-dark">
                                            <select value="" id="select{{ $key1.$key2 }}" 
                                                name="asistencias[{{ $key1.$key2 }}][permiso]" disabled
                                                onchange="combo(this.selectedIndex, {{ $key1.$key2 }});" onfocus="this.selectedIndex = -1;"
                                            >
                                                <option value="">Sin Permiso</option>
                                                <option value="LICENCIA">Licencia</option>
                                                <option value="BAJA_MEDICA">Baja medica</option>
                                                <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                                            </select>
                                            <br>
                                            <input class="{{$key1}}{{$key2}} mt-4" type="file" id="documento_adicional{{$key1}}{{$key2}}" name="asistencias[{{ $key1.$key2 }}][documento_adicional]" disabled>
                                        </td>
                                        <input type="hidden" name="asistencias[{{ $key1.$key2 }}][fecha]" value="{{ $fechasDeSemana[$horario->dia] }}">                        
                                        <input id='asistenciaFalse{{$key1.$key2}}' type='hidden' name="asistencias[{{ $key1.$key2 }}][asistencia]" value="true">
                                        <input type="hidden" name="asistencias[{{ $key1.$key2 }}][horario_clase_id]" value="{{ $horario->id }}">
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
                        @if ($llenado)
                            LA PLANILLA YA FUE LLENADA
                        @else
                            USTED NO TIENE CLASES ASIGNADAS
                        @endif
                    </h4>
            
                @endif
                <button class="btn boton float-right" id="registrar" style="display:none;">REGISTRAR</button>  
            </form>      
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
    <script>
        $(window).on('load', habilitarBotonRegistrar({{sizeof($horarios)}}));
    </script>
@endsection