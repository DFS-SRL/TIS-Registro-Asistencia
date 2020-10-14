@if(!$horarios->isEmpty())
    el docente {{ $horarios[0]->asignado->nombre }} <br>
    codigo sis {{ $horarios[0]->asignado->codSis }}
@endif
Desde {{ $fechaInicio }} hasta {{$fechaFinal}} <br>
Hoy es {{ getDia() }} <br>

@forelse ($horarios as $horario)
    ----------------------<br>
    fecha: CALCULAR SEGUN FECHA ACTUAL Y DIA DE SEMANA <br>
    dia: {{ $horario->dia }} <br>
    a las: {{ $horario->hora_inicio }} <br>    
    hasta las: {{ $horario->hora_fin }} <br>
    grupo:   {{ $horario->grupo->nombre }} <br>
    materia: {{ $horario->materia->nombre }} <br>
@empty
    no hay horarios :v
@endforelse