<h2>esta es la informacion del docente :v</h2>
<ul>
    @foreach ($asistencias as $asistencia)
        <li>
            {{ $asistencia->actividad_realizada . " " . $asistencia->asistencia . " " . $asistencia->permiso }}
        </li>
    @endforeach

    @foreach ($gruposActivos as $grupoActivo)
        <li>
            {{$grupoActivo->nombre}}
        </li>
    @endforeach
</ul>