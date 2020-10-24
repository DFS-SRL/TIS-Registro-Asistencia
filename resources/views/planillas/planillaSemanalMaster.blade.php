
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/semanalDocenteEstilo.css">
    
    <title>planilla semanal de asistencia</title>
</head>
<body>
    <div class="m-3">
    <div class="row">
        <div class="col-6">
            <h2 class = "textoBlanco">planilla semanal de asistencia</h2>
        </div>
        <div class = "col-6">
            <b class = "textoBlanco">desde: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
            <b class = "textoBlanco ml-4">hasta: </b><span class = "textoBlanco"> {{$fechaFinal}}</span>
        </div>
    </div>
    <form  method="POST"  @yield('action') onsubmit= "return valMinAct()">
    @if(!empty($horarios))
        <h4 class = "textoBlanco">@yield('tipoUsuario') {{$nombre}}</h4>
        <h4 class = "textoBlanco">Codigo SIS: {{$codSis}}</h4>
    @endif
    @forelse ($horarios as $key1 => $unidad)
        <br>
        <h4 class = "textoBlanco">{{$unidad[0]->unidad->facultad}} / {{$unidad[0]->unidad->nombre}}</h4>
            @csrf
            <table class = "table table-bordered">
                <tr>
                    <th class = "textoBlanco border border-dark">fecha</th>
                    <th class = "textoBlanco border border-dark">horario</th>
                    <th class = "textoBlanco border border-dark">grupo</th>
                    <th class = "textoBlanco border border-dark">materia</th>
                    <th class = "textoBlanco border border-dark">actividad realizada</th>
                    <th class = "textoBlanco border border-dark">indicador verificable</th>
                    <th class = "textoBlanco border border-dark">observaciones</th>
                    <th class = "textoBlanco border border-dark">asistencia</th>
                    <th class = "textoBlanco border border-dark">permiso</th>
                </tr>
                @foreach ($unidad as $key2 => $horario)
                    <tr>
                        <td class="border border-dark">{{ $fechasDeSemana[$horario->dia] }}</td>
                        <td class="border border-dark">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                        <td class="border border-dark">{{ $horario->grupo->nombre }}</td>
                        <td class="border border-dark">{{ $horario->materia->nombre }}</td>
                        <td class="border border-dark">
                            <textarea name="asistencias[{{ $key1.$key2 }}][actividad_realizada]" class ="{{$key1}}{{$key2}} actividad" 
                             maxlength="150" id="actividad{{$key1.$key2 }}"></textarea>                             
                             <label class ="text-danger" id="msgAct{{$key1.$key2 }}" for="actividad{{$key1.$key2 }}"></label>
                            </td>
                        <td class="border border-dark"><textarea name="asistencias[{{ $key1.$key2 }}][indicador_verificable]" class = "{{$key1}}{{$key2}}"></textarea></td>
                        <td class="border border-dark"><textarea name="asistencias[{{ $key1.$key2 }}][observaciones]" class = "{{$key1}}{{$key2}}" maxlength="200"></textarea></td>
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
                        {{-- <input id="actividadFalse{{$key1.$key2}}" type="hidden" name="asistencias[{{ $key1.$key2 }}][actividad_realizada]" >
                        <input id="indicadorFalse{{$key1.$key2}}" type="hidden" name="asistencias[{{ $key1.$key2 }}][indicador_verificable]" >
                        <input id="observacionesFalse{{$key1.$key2}}" type="hidden" name="asistencias[{{ $key1.$key2 }}][observaciones]" >
                        --}}
                        <input type="hidden" name="asistencias[{{ $key1.$key2 }}][fecha]" value="{{ $fechasDeSemana[$horario->dia] }}">                        
                        <input id='asistenciaFalse{{$key1.$key2}}' type='hidden' name="asistencias[{{ $key1.$key2 }}][asistencia]" value="true">
                        <input type="hidden" name="asistencias[{{ $key1.$key2 }}][horario_clase_id]" value="{{ $horario->id }}">
                     </tr>
                @endforeach
            </table>
    @empty
        <p>usted no tiene clases asignadas</p>
    @endforelse
    <button class="btn btn-success" >SUBIR</button>    
    </form>      
    </div>
    <script src="/js/main.js"></script>
</body>
</html>