Desde {{ $fechaInicio }} hasta {{$fechaFinal}} <br>
planilla de aux docente
@forelse ($asistencias as $asistencia)
    ----------------------<br>
    materia: {{ $asistencia->materia->nombre }} <br>
    grupo: {{ $asistencia->grupo->nombre }} <br>
    nombre: {{ $asistencia->usuario->nombre }} <br>
    fecha: {{ formatoFecha($asistencia->fecha) }} <br>
    a las: {{ $asistencia->horarioClase->hora_inicio }} <br>
    hasta las: {{ $asistencia->horarioClase->hora_fin }} <br>
    tarea realizada: {{ $asistencia->actividad_realizada }} <br>
    indicador verificable: {{ $asistencia->indicador_verificable }} <br>
    observaciones: {{ $asistencia->observaciones }} <br>
    asistencia: {{ $asistencia->asistencia ? 'SI' : 'NO' }} <br>
    permiso: {{ $asistencia->permiso ? $asistencia->permiso : '-' }} <br>

@empty
    no hay horarios :v
@endforelse 