@extends('parteMensual/master')
@section('tipoParte')
DOCENTES    
@endsection
@section('reporte')
<table class = "table table-bordered">
    <tr>
        <th class = "textoBlanco border border-dark">CODIGO SIS</th>
        <th class = "textoBlanco border border-dark">NOMBRE</th>
        <th class = "textoBlanco border border-dark">CARGA HORARIA</th>
        <th class = "textoBlanco border border-dark">HORAS ASISTIDAS</th>
        <th class = "textoBlanco border border-dark">HH. CON FALTA</th>
        <th class = "textoBlanco border border-dark">HH. CON LICENCIA</th>
        <th class = "textoBlanco border border-dark">HH. CON BAJA</th>
        <th class = "textoBlanco border border-dark">HH. CON DECLARATORIA</th>
        <th class = "textoBlanco border border-dark">HH. PAGABLES</th>
        <th class = "textoBlanco border border-dark">HH. NO PAGABLES</th>
    </tr>
    @foreach($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
            <td class="border border-dark">{{$value}}</td>
            
        @endforeach
        </tr>
    @endforeach
</table>
@endsection