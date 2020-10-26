
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planilla semanal de asistencia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/planillaSemanalEstilo.css">
    
</head>
<body onload="habilitarBotonRegistrar({{sizeof($horarios)}})">
    <div class="m-3">
    <div class="row">
        <div class="col-6">
            <h2 class = "textoBlanco">PLANILLA SEMANAL DE ASISTENCIA</h2>
        </div>
        <div class = "col-6">
            <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
            <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFinal}}</span>
        </div>
    </div>
    <form  method="POST"  @yield('action') onsubmit= "return valMinAct()">
    @if(!empty($horarios))
        <h4 class = "textoBlanco">@yield('tipoUsuario') {{$nombre}}</h4>
        <h4 class = "textoBlanco">CODIGO SIS: {{$codSis}}</h4>
    @endif
    @forelse ($horarios as $key1 => $unidad)
        <br>
        <h4 class = "textoBlanco">{{$unidad[0]->unidad->facultad}} / {{$unidad[0]->unidad->nombre}}</h4>
            @csrf
            <table class = "table table-bordered">
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
                             maxlength="150" id="actividad{{$key1.$key2 }}" onkeypress="valLimAct({{$key1.$key2 }})" onkeyup="valLimAct({{$key1.$key2 }})"  ></textarea>                             
                             <label class ="text-danger" id="msgAct{{$key1.$key2 }}" for="actividad{{$key1.$key2 }}"></label>
                            </td>
                        <td class="border border-dark"><textarea name="asistencias[{{ $key1.$key2 }}][indicador_verificable]" class = "{{$key1}}{{$key2}}"></textarea></td>
                        <td class="border border-dark">
                            <textarea name="asistencias[{{ $key1.$key2 }}][observaciones]" class = "{{$key1}}{{$key2}} observacion" 
                            maxlength="200" id="observacion{{$key1.$key2 }}" onkeypress="valLimObs({{$key1.$key2 }})" onkeyup="valLimObs({{$key1.$key2 }})" ></textarea>                            
                            <label class ="text-danger" id="msgObs{{$key1.$key2 }}" for="observaciones"></label>
                            </td>
                        <td class="border border-dark">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="asistencia{{$key1}}{{$key2}}" onclick='habilitarDeshabilitar({{$key1.$key2}})' checked/>
                                <label class="custom-control-label" for="asistencia{{$key1}}{{$key2}}"></label>
                            </div>
                        </td>
                        <td class="border border-dark">
                            <select name="asistencias[{{ $key1.$key2 }}][permiso]" id="select{{$key1}}{{$key2}}" disabled>
                                <option value="LICENCIA">Licencia</option>
                                <option value="BAJA_MEDICA">Baja medica</option>
                                <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>  
                            </select>
                        </td>
                        <input type="hidden" name="asistencias[{{ $key1.$key2 }}][fecha]" value="{{ $fechasDeSemana[$horario->dia] }}">                        
                        <input id='asistenciaFalse{{$key1.$key2}}' type='hidden' name="asistencias[{{ $key1.$key2 }}][asistencia]" value="true">
                        <input type="hidden" name="asistencias[{{ $key1.$key2 }}][horario_clase_id]" value="{{ $horario->id }}">
                     </tr>
                @endforeach
            </table>
    @empty 
    <br>
    <br>
    <br>
    <br>
    <br>    
        <h4 class="text-center textoBlanco">USTED NO TIENE CLASES ASIGNADAS</h4>
    @endforelse  
    <button class="btn boton float-right" id="registrar" style="display:none;">REGISTRAR</button>  
    </form>      
    </div>
    <script src="/js/main.js"></script>
</body>
</html>