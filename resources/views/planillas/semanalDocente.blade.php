
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
    @if(!empty($horarios))
        <h4 class = "textoBlanco">Docente: {{$horarios[0][0]->asignado->nombre}}</h4>
        <h4 class = "textoBlanco">Codigo SIS: {{$horarios[0][0]->asignado->codSis}}</h4>
    @endif
    @forelse ($horarios as $key1 => $unidad)
        <br>
        <h4 class = "textoBlanco">{{$unidad[0]->unidad->facultad}} / {{$unidad[0]->unidad->nombre}}</h4>
        <form>
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
                        <td class="border border-dark"><textarea name="actividad" class ="{{$key1}}{{$key2}}" maxlength="150" disabled></textarea></td>
                        <td class="border border-dark"><textarea name="indicador" class = "{{$key1}}{{$key2}}" disabled></textarea></td>
                        <td class="border border-dark"><textarea name="observaciones" class = "{{$key1}}{{$key2}}" maxlength="200" disabled></textarea></td>
                        <td class="border border-dark">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="asistencia{{$key1}}{{$key2}}" onclick='habilitarDeshabilitar(this)'/>
                                <label class="custom-control-label" for="asistencia{{$key1}}{{$key2}}"></label>
                            </div>
                        </td>
                        <td class="border border-dark">
                            <select name="permiso" id="select{{$key1}}{{$key2}}">
                                <option value="licencia">licencia</option>
                                <option value="baja">baja médica</option>
                                <option value="declaratoria">declaratoria en comisión</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </table>
        </form>
    @empty
        <p>usted no tiene clases asignadas</p>
    @endforelse
    </div>
    <script src="/js/main.js"></script>
</body>
</html>