llegaste maravilla!!! {{ $unidad }} <br>
planilla mensual de asistencia <br>
auxiliares <br>
del {{ $fechaInicio }} al {{ $fechaFin }} <br>
{{ $unidad->facultad . " / " . $unidad->nombre }} <br>
gestion {{ $gestion }}
<br><br>
auxiliares de laboratorio <br>
@foreach ($parteLabo as $reporte)
    @foreach ($reporte as $key => $value)
        {{ $key . " => " . $value . " || "}}
    @endforeach
    <br>
@endforeach
<br><br>
auxiliares de docencia <br>
@foreach ($parteDoc as $reporte)
    @foreach ($reporte as $key => $value)
        {{ $key . " => " . $value . " || "}}
    @endforeach
    <br>
@endforeach

<br><br>
combinado <br>
@foreach ($parteCombinado as $reporte)
    @foreach ($reporte as $key => $value)
        {{ $key . " => " . $value . " || "}}
    @endforeach
    <br>
@endforeach

<br><br>
tot pagables: {{ $totPagables }} <br>
tot no pagables: {{ $totNoPagables }} <br>