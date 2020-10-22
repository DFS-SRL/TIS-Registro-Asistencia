llegaste maravilla!!! {{ $unidad }} <br>
planilla mensual de asistencia<br>
docentes <br>
del {{ $fechaInicio }} al {{ $fechaFin }} <br>
{{ $unidad->facultad . " / " . $unidad->nombre }} <br>
gestion {{ $gestion }}
<br><br>
docentes <br>
@foreach ($parteDoc as $reporte)
    @foreach ($reporte as $key => $value)
        {{ $key . " => " . $value . " || "}}
    @endforeach
    <br>
@endforeach
<br><br>

tot pagables: {{ $totPagables }} <br>
tot no pagables: {{ $totNoPagables }} <br>