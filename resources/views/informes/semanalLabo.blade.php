asdf <br>

Informe semanal de asistencia <br>
{{ $unidad->facultad }} / {{ $unidad->nombre }} <br>

Desde {{ $fechaInicio }} hasta {{$fechaFinal}} <br>

@forelse ($asistencias as $asistencia)
    ----------------------<br>
    cargo: {{ $asistencia->materia->nombre }} <br>
    nombre: {{ $asistencia->usuario->nombre }} <br>
    fecha: {{ formatoFecha($asistencia->fecha) }} <br>
    a las: {{ $asistencia->horarioClase->hora_inicio }} <br>
    hasta las: {{ $asistencia->horarioClase->hora_fin }} <br>
    tarea realizada: {{ $asistencia->actividad_realizada }} <br>
    observaciones: {{ $asistencia->observaciones }} <br>
    asistencia: {{ $asistencia->asistencia ? 'SI' : 'NO' }} <br>
    permiso: {{ $asistencia->permiso ? $asistencia->permiso : 'sin permiso' }} <br>

@empty
    no hay horarios :v
@endforelse