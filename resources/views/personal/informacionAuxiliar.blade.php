<h2>esta es la informacion del auxiliar :v</h2>
<h4>grupos activos</h4>
<ul>
    @foreach ($gruposActivos as $grupoActivo)
        <li>
            {{$grupoActivo->nombre}}
        </li>
    @endforeach
</ul>
<h4>items activos</h4>
<ul>
    @foreach ($itemsActuales as $itemActual)
        <li>
            {{$itemActual->nombre}}
        </li>
    @endforeach
</ul>


<h4> asistencias </h4>
<ul>
    @foreach ($asistencias as $asistencia)
        <li>
            {{ 
                "fecha: " . $asistencia->fecha . ", materia: ". $asistencia->materia->nombre 
                . ", grupo: " . $asistencia->grupo->nombre
                . ", actividad: " . $asistencia->actividad_realizada 
                . ", asistencia: " . $asistencia->asistencia 
                . ", permiso: " . $asistencia->permiso
            }}
        </li>
    @endforeach
    {{ $asistencias->links() }}
</ul>