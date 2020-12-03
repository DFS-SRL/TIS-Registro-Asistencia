@extends('/parteMensual/masterPDF')
@section('tipoParte')
    AUXILIARES
@endsection
@section('reporte')
    @if (!empty($parteCombinado))
        <div id="combinado">
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
                @foreach ($parteCombinado as $reporte)
                    <tr>
                        @foreach ($reporte as $key => $value)
                            <td class="border border-dark">
                                {{ $value }}
                            </td> 
                        @endforeach
                    </tr>
                @endforeach
            </table>
        </div>
        <br>
        <strong class="textoBlanco">Total horas pagables: {{ $totPagables }}</strong> <br>
        <strong class="textoBlanco">Total horas no pagables: {{ $totNoPagables }}</strong> <br>
    @else
        <h4 class="textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
    @endif

@endsection
