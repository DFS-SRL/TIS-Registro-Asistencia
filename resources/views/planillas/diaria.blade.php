@extends('layouts.master')

@section('title', 'Auxiliar Laboratorio')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2 class="textoBlanco">PLANILLA DIARIA DE ASISTENCIA</h2>
                <h4 class="textoBlanco">NOMBRE AUXILIAR LABORATORIO: {{ $usuario->nombre() }}</h4>
                <h4 class="textoBlanco">CODSIS: {{ $usuario->codSis }} </h4>

            </div>
            <div class="col-4">
                <b class="textoBlanco">DIA: </b><span class="textoBlanco"> {{ getDia() }}</span>
                <b class="textoBlanco ml-4">FECHA: </b><span class="textoBlanco"> {{ $fecha }}</span>
            </div>
        </div>
        @if (!$horarios->isEmpty())
            <table class="table table-responsive">
                <tr>
                    <th class="textoBlanco border border-dark" scope="col">HORARIO</th>
                    <th class="textoBlanco border border-dark" scope="col">CARGO</th>
                    <th class="textoBlanco border border-dark" scope="col">ACTIVIDAD REALIZADA</th>
                    <th class="textoBlanco border border-dark" scope="col">OBSERVACIONES</th>
                    <th class="textoBlanco border border-dark" scope="col">ASISTENCIA</th>
                    <th class="textoBlanco border border-dark" scope="col">PERMISO</th>
                </tr>
                <form method="POST" action="{{ route('planillas.diaria') }}" onsubmit="return valMinAct()" enctype="multipart/form-data">
                    @csrf
                    @foreach ($horarios as $key => $horario)
                        <tr>
                            <td class="border border-dark">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                            <td class="border border-dark">{{ $horario->materia->nombre }}</td>
                            <td class="border border-dark">
                                <textarea class="{{ $key }} actividad" name="asistencias[{{ $key }}][actividad_realizada]"
                                    id="actividad{{ $key }}" onkeypress="valLim(150, 'actividad{{ $key }}', 'msgAct{{ $key }}')"
                                    onkeyup="valLim(150, 'actividad{{ $key }}', 'msgAct{{ $key }}')" maxlength="150"></textarea>
                                <label class="text-danger" id="msgAct{{ $key }}" for="actividad{{ $key }}"></label>
                            </td>
                            <td class="border border-dark">
                                <textarea class="{{ $key }}" name="asistencias[{{ $key }}][observaciones]"
                                    id="observacion{{ $key }}" onkeypress="valLim(200, 'observacion{{ $key }}', 'msgObs{{ $key }}')"
                                    onkeyup="valLim(200, 'observacion{{ $key }}', 'msgObs{{ $key }}')" maxlength="200"></textarea>
                                <label class="text-danger" id="msgObs{{ $key }}" for="observaciones"></label>
                            </td>
                            <td class="border border-dark">
                                <div class="custom-control custom-switch">
                                    <input onchange="habilitarDeshabilitar({{ $key }})" type="checkbox"
                                        class="custom-control-input" id="asistencia{{ $key }}" autocomplete="off" checked />
                                    <label class="custom-control-label" for="asistencia{{ $key }}"></label>
                                </div>
                            </td>
                            <td class="border border-dark">
                                <div class="input-group form-group">
                                    <select value="" id="select{{ $key }}" 
                                        name="asistencias[{{ $key }}][permiso]" disabled
                                        onchange="combo(this.selectedIndex, {{ $key }});" onfocus="this.selectedIndex = -1;"
                                    >
                                        <option onselect="console.log('sin perma')" value="">Sin Permiso</option>
                                        <option onclick="window.alert('licensa')" value="LICENCIA">Licencia</option>
                                        <option onclick="window.alert('bashs')" value="BAJA_MEDICA">Baja medica</option>
                                        <option onclick="window.alert('comisionado gordon')" value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                                    </select>
                                </div>
                                {{-- <br class="borrar"> --}}
                                <div class="input-group form-group">
                                    <button type="button" class="{{$key}} borrar btn btn-block boton justify-content-center" id="documento_adicional{{$key}}"  style="font-size:0.7em;" onclick="asistenciaEventButton({{$key}});" disabled>COMPROBANTE  <svg width="1.1em" height="1.1em" viewBox="0 0 18 18" class="bi bi-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg" >
                                        <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                        <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                                        </svg>
                                    </button >
                                    <label class="{{$key}} borrar" id="nombre_archivo{{$key}}"  for="documento_adicional{{$key}}"></label>
                                    <input class="{{$key}} mt-4" type="file" id="documento-form{{$key}}" name="asistencias[{{ $key }}][documento_adicional]"style="display:none" 
                                    onchange="setLabelFile({{$key}})">
                                </div>
                            
                            </td>
                        </tr>
                        <input id='asistenciaFalse{{ $key }}' type='hidden' name="asistencias[{{ $key }}][asistencia]"
                            value="true">
                        <input type="hidden" name="asistencias[{{ $key }}][horario_clase_id]" value="{{ $horario->id }}">
                    @endforeach
            </table>
            <button class="btn boton float-right" id="subir">SUBIR</button>
            </form>
        @else
            <br>
            <br>
            <br>
            <br>
            <br>
            @if ($llenado)
                <h4 class="text-center  textoBlanco">LA PLANILLA YA FUE LLENADA</h4>
            @else
                <h4 class="text-center textoBlanco">NO HAY HORARIOS</h4>
            @endif
        @endif
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
    <script >
        function asistenciaEventButton(asistenciaId){
            document.getElementById("documento-form" + asistenciaId).removeAttribute("disabled");
            document.getElementById("documento-form" + asistenciaId).click();        
        }
        function setLabelFile(asistenciaId){
            file = document.getElementById("documento-form"+asistenciaId).value.split('\\')[2]
            document.getElementById("nombre_archivo"+asistenciaId).innerText=file;
        }

    </script>
@endsection
