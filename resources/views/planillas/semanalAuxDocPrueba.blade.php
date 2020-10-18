@if(!$horarios->isEmpty())
    el auxiliar {{ $horarios[0]->asignado->nombre }} <br>
    codigo sis {{ $horarios[0]->asignado->codSis }}
@endif
Desde {{ $fechaInicio }} hasta {{$fechaFinal}} <br>

@forelse ($horarios as $horario)
    ----------------------<br>
    fecha: {{ $fechasDeSemana[$horario->dia] }} <br>
    dia: {{ $horario->dia }} <br>
    a las: {{ $horario->hora_inicio }} <br>    
    hasta las: {{ $horario->hora_fin }} <br>
    grupo:   {{ $horario->grupo->nombre }} <br>
    materia: {{ $horario->materia->nombre }} <br>
    unidad: {{ $horario->unidad->nombre }} <br>
@empty
    no hay horarios :v
@endforelse