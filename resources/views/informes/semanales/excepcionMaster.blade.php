@extends('layouts.master')

@section('title', 'Planilla semanal de asistencia')

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h2 class = "textoBlanco" >PLANILLA SEMANAL DE EXCEPCION @yield('tipo_academico')</h2>
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
                <table class="table table-responsive">
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
                    @foreach ($asistencias as $key => $asistencia)
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
                                    {{ $asistencia->usuario->nombre() }}
                                </a>
                            </td>
                            <td class = "border border-dark">{{ $asistencia->usuario->codSis }} </td>
                            <td class = "border border-dark">{{ formatoFecha($asistencia->fecha) }}</td>
                            <td class = "border border-dark">{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }} </td>
                            <td class = "border border-dark">
                                <textarea name="asistencias[{{ $key }}][actividad_realizada]" class ="{{ $key }} actividad" 
                                maxlength="150" id="actividad{{$key }}" onkeypress="valLim(150, 'actividad{{$key}}', 'msgAct{{$key}}')"
                                onkeyup="valLim(150, 'actividad{{$key}}', 'msgAct{{$key}}')" >{{ $asistencia->actividad_realizada }}</textarea>                             
                                <label class ="text-danger" id="msgAct{{$key }}" for="actividad{{ $key }}"></label>
                            </td>
                            <td class = "border border-dark">
                                <textarea name="asistencias[{{ $key }}][indicador_verificable]" class = "{{ $key }} verificable" 
                                id="verificable{{$key }}">{{ $asistencia->indicador_verificable }}</textarea>
                                <label class ="text-danger" id="msgVer{{$key }}" for="verificable{{$key }}"></label>
                            </td>
                            <td class = "border border-dark">
                                <textarea name="asistencias[{{ $key }}][observaciones]" class = "{{ $key }} observacion"
                                maxlength="200" id="observacion{{ $key }}" onkeypress="valLim(200, 'observacion{{$key}}', 'msgObs{{$key}}')"
                                onkeyup="valLim(200, 'observacion{{$key}}', 'msgObs{{$key}}')">{{ $asistencia->observaciones }}</textarea>                            
                                <label class ="text-danger" id="msgObs{{ $key }}" for="observaciones"></label>
                            </td>
                            <td class = "border border-dark">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="asistencia{{$key}}" onclick='habilitarDeshabilitar({{$key}}); datos({{$key}})' autocomplete="off" checked/>
                                    <label class="custom-control-label" for="asistencia{{$key}}"></label>
                                </div>
                            </td>
                            {{-- <td class = "border border-dark"> {{ $asistencia->permiso ? $asistencia->permiso : '' }} </td> --}}
                            <td class="border border-dark">
                                <select value="" id="select{{ $key }}" 
                                    name="asistencias[{{ $key }}][permiso]" disabled
                                    onchange="combo(this.selectedIndex, {{ $key }});" onfocus="this.selectedIndex = -1;">

                                    <option value="">Sin Permiso</option>
                                    <option value="LICENCIA">Licencia</option>
                                    <option value="BAJA_MEDICA">Baja medica</option>
                                    <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                                </select>
                                <br>
                                <input class="{{$key}} mt-4" type="file" id="documento_adicional{{$key}}" name="asistencias[{{ $key }}][documento_adicional]" disabled>
                            </td>                      
                            <input id='asistenciaFalse{{$key}}' type='hidden' name="asistencias[{{ $key }}][asistencia]" value="true">
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
    <script>
        var a = @json($asistencias);
        console.log(a);

        llenarDatos();

        function llenarDatos(){
            for(let i = 0; i < a.length; i++){
                let asistencia = a[i];

                $('#observacion' + i).val(asistencia.observaciones);
                $('#actividad' + i).val(asistencia.actividad_realizada);
                $('#verificable' + i).val(asistencia.indicador_verificable);
                $('#select' + i).val(asistencia.permiso);

                if(!asistencia.asistencia){
                    $('#asistencia' + i).click();
                }

                if(asistencia.permiso !== null){
                    $('#observacion' + i).removeAttr('disabled');
                    $('#observacion' + i).val(asistencia.observaciones);
                }
            }
        }

        
        function datos(i){
            let asistencia = a[i];
            // console.log($('#asistenciaFalse' + i).attr('value') === 'true');
            if($('#asistenciaFalse' + i).attr('value') === 'true'){
                $('#observacion' + i).val(asistencia.observaciones);
                $('#actividad' + i).val(asistencia.actividad_realizada);
                $('#verificable' + i).val(asistencia.indicador_verificable);
                $('#select' + i).val(asistencia.permiso);
            }else{
                $('#observacion' + i).val('');
                $('#actividad' + i).val('');
                $('#verificable' + i).val('');
                $('#select' + i).val('');
            }
        }
    </script>
@endsection
