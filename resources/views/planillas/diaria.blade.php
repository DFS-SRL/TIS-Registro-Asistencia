@if(!$horarios->isEmpty())
    el auxiliar de laboratorio {{ $horarios[0]->asignado->nombre }} <br>
    en el dia {{ $horarios[0]->dia }} <br>
@endif
en la fecha {{ $fecha }} <br>

@forelse ($horarios as $horario)
    ----------------------<br>
    a las: {{ $horario->hora_inicio }} <br>    
    hasta las: {{ $horario->hora_fin }} <br>
    cargo: {{ $horario->materia->nombre }} <br>
    puesto: {{ $horario->grupo->nombre }} <br>
@empty
    no hay horarios :v
@endforelse