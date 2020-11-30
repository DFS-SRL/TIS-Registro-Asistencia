@extends('parteMensual/master')
@section('tipoParte')
    DOCENTES
@endsection
@section('reporte')
    @if (!@empty($parteDoc))
        <table class="table table-responsive">
            <tr>
                <th class="textoBlanco border border-dark">CODIGO SIS</th>
                <th class="textoBlanco border border-dark">NOMBRE</th>
                <th class="textoBlanco border border-dark">C. HORARIA NOMINAL</th>
                <th class="textoBlanco border border-dark">C. HORARIA EFECTIVA</th>
                <th class="textoBlanco border border-dark">HORAS ASISTIDAS</th>
                <th class="textoBlanco border border-dark">HH. CON FALTA</th>
                <th class="textoBlanco border border-dark">HH. CON LICENCIA</th>
                <th class="textoBlanco border border-dark">HH. CON BAJA</th>
                <th class="textoBlanco border border-dark">HH. CON DECLARATORIA</th>
                <th class="textoBlanco border border-dark">HH. PAGABLES</th>
                <th class="textoBlanco border border-dark">HH. NO PAGABLES</th>
            </tr>
            @foreach ($parteDoc as $reporte)
                <tr>
                    @foreach ($reporte as $key => $value)
                    <td class="border border-dark">
                        @if ($key == 'nombre')
                            <a 
                                href="{{ route('informes.mensual.docente', [
                                    'unidad' => $unidad->id,
                                    'fecha' => $fecha,
                                    'usuario' => $reporte['codSis']
                                ]) }}"
                            >
                                {{ $value }}
                            </a>
                        @else
                            {{ $value }}
                        @endif
                    </td>    

                    @endforeach
                </tr>
            @endforeach
        </table>
        <strong class="textoBlanco">Total horas pagables: {{ $totPagables }}</strong> <br>
        <strong class="textoBlanco">Total horas no pagables: {{ $totNoPagables }}</strong> <br>
    @else
        <h4 class="textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
    @endif
@endsection
