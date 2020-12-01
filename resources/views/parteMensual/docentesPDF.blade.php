@extends('parteMensual/masterPDF')
@section('tipoParte')
    DOCENTES
@endsection
@section('reporte')
    @if (!@empty($parteDoc))
        <table>
            <tr>
                <th>CODIGO SIS</th>
                <th>NOMBRE</th>
                <th>C. HORARIA NOMINAL</th>
                <th>C. HORARIA EFECTIVA</th>
                <th>HORAS ASISTIDAS</th>
                <th>HH. CON FALTA</th>
                <th>HH. CON LICENCIA</th>
                <th>HH. CON BAJA</th>
                <th>HH. CON DECLARATORIA</th>
                <th>HH. PAGABLES</th>
                <th>HH. NO PAGABLES</th>
            </tr>
            @foreach ($parteDoc as $reporte)
                <tr>
                    @foreach ($reporte as $key => $value)
                    <td>
                            {{ $value }}
                    </td>    

                    @endforeach
                </tr>
            @endforeach
        </table>
        <br>
        <strong>Total horas pagables: {{ $totPagables }}</strong> <br>
        <strong>Total horas no pagables: {{ $totNoPagables }}</strong> <br>
    @else
        <h4>NO HAY ASISTENCIAS REGISTRADAS</h4>
    @endif
@endsection
