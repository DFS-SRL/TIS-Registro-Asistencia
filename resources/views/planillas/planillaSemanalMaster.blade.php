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
                <form  method="POST" id="form-planilla" @yield('action') @yield('onsubmit') enctype="multipart/form-data">
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
                                            <textarea 
                                                name="asistencias[{{ $horario->id }}][actividad_realizada]" class ="{{ $horario->id }} actividad" 
                                                maxlength="150" id="actividad{{ $horario->id }}" 
                                                onkeypress="valLim(150, 'actividad{{ $horario->id }}', 'msgAct{{ $horario->id }}')" 
                                                onkeyup="valLim(150, 'actividad{{ $horario->id }}', 'msgAct{{ $horario->id }}')"></textarea>                             
                                            <label class ="text-danger" id="msgAct{{ $horario->id }}" for="actividad{{ $horario->id }}"></label>
                                        </td>
                                        <td class="border border-dark">
                                            <textarea 
                                                name="asistencias[{{ $horario->id }}][indicador_verificable]" class = "{{ $horario->id }}  verificable" 
                                                id="verificable{{ $horario->id }}"></textarea>
                                            <label class ="text-danger" id="msgVer{{$horario->id }}" for="verificable{{ $horario->id }}"></label>
                                        </td>
                                        <td class="border border-dark">
                                            <textarea 
                                                name="asistencias[{{ $horario->id }}][observaciones]" class = "{{ $horario->id }} observacion" 
                                                maxlength="200" id="observacion{{ $horario->id }}" 
                                                onkeypress="valLim(200, 'observacion{{ $horario->id }}', 'msgObs{{ $horario->id }}')" 
                                                onkeyup="valLim(200, 'observacion{{ $horario->id }}', 'msgObs{{ $horario->id }}')"></textarea>                            
                                            <label class ="text-danger" id="msgObs{{ $horario->id }}" for="observaciones"></label>
                                        </td>
                                        <td class="border border-dark">
                                            <div class="custom-control custom-switch">
                                                <input 
                                                    type="checkbox" class="custom-control-input" id="asistencia{{ $horario->id }}" 
                                                    onclick='habilitarDeshabilitar({{$horario->id}})' autocomplete="off" checked
                                                >
                                                <label class="custom-control-label" for="asistencia{{ $horario->id }}"></label>
                                            </div>
                                        </td>
                                        <td class="border border-dark">
                                            <div class="input-group form-group">
                                                <select 
                                                    value="" id="select{{ $horario->id }}" 
                                                    name="asistencias[{{ $horario->id }}][permiso]" disabled
                                                    onchange="combo(this.selectedIndex, {{ $horario->id }});"
                                                >
                                                    <option value="">Sin Permiso</option>
                                                    <option value="LICENCIA">Licencia</option>
                                                    <option value="BAJA_MEDICA">Baja medica</option>
                                                    <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                                                </select>
                                            </div>
                                            {{-- <br class="borrar"> --}}
                                            <div class="input-group form-group">
                                                <button type="button" class="{{$horario->id }} borrar btn btn-block boton justify-content-center" id="documento_adicional{{$horario->id }}"  style="font-size:0.7em;" onclick="asistenciaEventButton({{$horario->id }});" disabled>COMPROBANTE  <svg width="1.1em" height="1.1em" viewBox="0 0 18 18" class="bi bi-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg" >
                                                    <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                    <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                                    </svg>
                                                </button ><br>
                                                <label class="{{$horario->id}} borrar" id="nombre_archivo{{$horario->id }}"  for="documento_adicional{{$horario->id }}"></label>
                                            
                                                <input class="{{$horario->id }} mt-4" type="file" id="documento-form{{$horario->id }}" name="asistencias[{{$horario->id  }}][documento_adicional]"style="display:none" 
                                                onchange="setLabelFile({{$horario->id }})">
                                            </div>
                                        </td>
                                        <input type="hidden" name="asistencias[{{ $horario->id }}][fecha]" value="{{ $fechasDeSemana[$horario->dia] }}">                        
                                        <input id='asistenciaFalse{{$horario->id}}' type='hidden' name="asistencias[{{ $horario->id }}][asistencia]" value="true">
                                        <input type="hidden" name="asistencias[{{ $horario->id }}][horario_clase_id]" value="{{ $horario->id }}">
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
                <button class="btn boton float-right" id="registrar" style="display:none;">ENVIAR</button>  
            </form>  
            <button class="btn boton float-right mr-4" id="guardar-planilla" style="display:none" onclick="guardarPlanilla()">GUARDAR</button>    
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
    <script src="/js/planilla/planilla.js"></script>
    <script>
        $(window).on('load', habilitarBotonRegistrar({{sizeof($horarios)}}));
        function asistenciaEventButton(asistenciaId){
            document.getElementById("documento-form" + asistenciaId).removeAttribute("disabled");
            document.getElementById("documento-form" + asistenciaId).click();        
        }
        function setLabelFile(asistenciaId){
            file = document.getElementById("documento-form"+asistenciaId).value.split('\\')[2]
            document.getElementById("nombre_archivo"+asistenciaId).innerText=file;
        }
        
        var rutaPlanilla = "{{ route('planilla.guardar') }}";
        @foreach($planillas as $key => $planilla)
            cargarPlanilla(@json($planilla), true);
        @endforeach
    </script>
@endsection