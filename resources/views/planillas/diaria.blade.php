@if(!$horarios->isEmpty())
    el auxiliar de laboratorio {{ $horarios[0]->asignado->nombre }} <br>
    en el dia {{ $horarios[0]->dia }} <br>
@endif
en la fecha {{ $fecha }} <br>

<form method="POST" action="{{ route('planillas.diaria') }}">
    @csrf
    @forelse ($horarios as $key => $horario)
        ----------------------<br>
        {{$key}} <br>
        a las: {{ $horario->hora_inicio }} <br>    
        hasta las: {{ $horario->hora_fin }} <br>
        cargo: {{ $horario->materia->nombre }} <br>
        puesto: {{ $horario->grupo->nombre }} <br>
        <input type="text" name="asistencias[{{ $key }}][actividad_realizada]" value="nada" />
        <input type="text" name="asistencias[{{ $key }}][observaciones]" value="todo" />
        <input type="text" name="asistencias[{{ $key }}][asistencia]" value="true" />
        <input type="text" name="asistencias[{{ $key }}][permiso]" />

        <input type="text" name="asistencias[{{ $key }}][horario_clase_id]" value="{{ $horario->id }}" style="display: none;">
    @empty
        no hay horarios :v
    @endforelse
    <button>listo kk</button>
</form>