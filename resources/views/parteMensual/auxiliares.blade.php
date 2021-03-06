@extends('/parteMensual/master')
@section('tipoParte')
    AUXILIARES
@endsection
@section('select')
    <br>
    <br>
    <br>
    <label class="radio-inline textoBlanco "><input type="radio" name="optradio" onclick="combinado()" autocomplete="off"
            checked>Combinado</label>
    <label class="radio-inline textoBlanco "><input type="radio" name="optradio" onclick="separado()"
            autocomplete="off">Separado</label>
@endsection
@section('reporte')
    @if (!empty($parteCombinado))
        <div id="combinado">
            <h4 class="textoBlanco">COMBINADO</h4>
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
                @foreach ($parteCombinado as $reporte)
                    <tr>
                        @foreach ($reporte as $key => $value)
                            <td class="border border-dark">
                                @if ($key == 'nombre')
                                    <a 
                                        href="{{ route('informes.mensual.auxiliar', [
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
        </div>
        <div id="separado" style="display:none;">
            <h4 class="textoBlanco">AUXILIARES DE LABORATORIO</h4>
            @if (!empty($parteLabo))
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
                    @foreach ($parteLabo as $reporte)
                        <tr>
                            @foreach ($reporte as $key => $value)
                                <td class="border border-dark">
                                    @if ($key == 'nombre')
                                        <a 
                                            href="{{ route('informes.mensual.auxiliar', [
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
            @else
                <h4 class="textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
            @endif

            <h4 class="textoBlanco">AUXILIARES DE DOCENCIA</h4>
            @if (!empty($parteDoc))
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
                                            href="{{ route('informes.mensual.auxiliar', [
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
            @else
                <h4 class="textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
            @endif

        </div>

        <strong class="textoBlanco">Total horas pagables: {{ $totPagables }}</strong> <br>
        <strong class="textoBlanco">Total horas no pagables: {{ $totNoPagables }}</strong> <br>
    @else
        <h4 class="textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
    @endif

@endsection

@section('script-footer')
    @parent
    <script>
        function combinado() {
            document.getElementById('combinado').style.display = "block";
            document.getElementById('separado').style.display = "none";
        }

        function separado() {
            document.getElementById('combinado').style.display = "none";
            document.getElementById('separado').style.display = "block";
        }

    </script>
@endsection
