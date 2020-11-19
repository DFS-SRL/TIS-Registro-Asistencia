<h1>{{ $unidad->facultad }}</h1>
<h1>{{ $unidad->nombre }}</h1>
<h2>{{ $usuario->nombre }}</h2>
<h2>codSis: {{ $usuario->codSis }}</h2>
<h4>grupos actuales</h4>
<ul>
    @if (!$gruposActuales->isempty())
        <h5>carga horaria nominal semanal de grupos de docencia: {{ $cargaHorariaNominalGrupos }}</h5>
        @foreach ($gruposActuales as $grupoActual)
            <li>
                {{ $grupoActual }}
            </li>
        @endforeach
    @endif
</ul>
<h4>grupos pasados</h4>
<ul>
    @foreach ($gruposPasados as $grupoPasado)
        <li>
            {{ $grupoPasado }}
        </li>
    @endforeach
</ul>
<h4>items actuales</h4>
<ul>
    @if (!$itemsActuales->isempty())
        <h5>carga horaria nominal semanal de items de laboratorio: {{ $cargaHorariaNominalItems }}</h5>
        @foreach ($itemsActuales as $itemActual)
            <li>
                {{ $itemActual }}
            </li>
        @endforeach
    @endif
</ul>
<h4>items pasados</h4>
<ul>
    @foreach ($itemsPasados as $itemPasado)
        <li>
            {{ $itemPasado }}
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