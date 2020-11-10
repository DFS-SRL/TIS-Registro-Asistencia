@extends('layouts.master')

@section('title', 'Auxiliar Laboratorio')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h2 class="textoBlanco">PLANILLA DIARIA DE ASISTENCIA</h2>
                <h4 class="textoBlanco">NOMBRE AUXILIAR LABORATORIO: {{ $usuario->nombre }}</h4>
                <h4 class="textoBlanco">CODSIS: {{ $usuario->codSis }} </h4>

            </div>
            <div class="col-4">
                <b class="textoBlanco">DIA: </b><span class="textoBlanco"> {{ getDia() }}</span>
                <b class="textoBlanco ml-4">FECHA: </b><span class="textoBlanco"> {{ $fecha }}</span>
            </div>
        </div>
        @if (!$horarios->isEmpty())
            <table class="table">
                <tr>
                    <th class="textoBlanco border border-dark" scope="col">HORARIO</th>
                    <th class="textoBlanco border border-dark" scope="col">CARGO</th>
                    <th class="textoBlanco border border-dark" scope="col">ACTIVIDAD REALIZADA</th>
                    <th class="textoBlanco border border-dark" scope="col">OBSERVACIONES</th>
                    <th class="textoBlanco border border-dark" scope="col">ASISTENCIA</th>
                    <th class="textoBlanco border border-dark" scope="col">PERMISO</th>
                </tr>
                <form method="POST" action="{{ route('planillas.diaria') }}" onsubmit="return valMinAct()">
                    @csrf
                    @foreach ($horarios as $key => $horario)
                        <tr>
                            <td class="border border-dark">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                            <td class="border border-dark">{{ $horario->materia->nombre }}</td>
                            <td class="border border-dark">
                                <textarea class="{{ $key }} actividad" name="asistencias[{{ $key }}][actividad_realizada]"
                                    id="actividad{{ $key }}" onkeypress="valLimAct({{ $key }})"
                                    onkeyup="valLimAct({{ $key }})" maxlength="150"></textarea>
                                <label class="text-danger" id="msgAct{{ $key }}" for="actividad{{ $key }}"></label>
                            </td>
                            <td class="border border-dark">
                                <textarea class="{{ $key }}" name="asistencias[{{ $key }}][observaciones]"
                                    id="observacion{{ $key }}" onkeypress="valLimObs({{ $key }})"
                                    onkeyup="valLimObs({{ $key }})" maxlength="200"></textarea>
                                <label class="text-danger" id="msgObs{{ $key }}" for="observaciones"></label>
                            </td>
                            <td class="border border-dark">
                                <div class="custom-control custom-switch">
                                    <input onchange="habilitarDeshabilitar({{ $key }})" type="checkbox"
                                        class="custom-control-input" id="asistencia{{ $key }}" autocomplete="off" checked />
                                    <label class="custom-control-label" for="asistencia{{ $key }}"></label>
                                </div>
                            </td>
                            <td class="border border-dark">
                                <select id="select{{ $key }}" name="asistencias[{{ $key }}][permiso]" disabled>
                                    <option value="LICENCIA">Licencia</option>
                                    <option value="BAJA_MEDICA">Baja medica</option>
                                    <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                                </select>
                            </td>
                        </tr>
                        <input id='asistenciaFalse{{ $key }}' type='hidden' name="asistencias[{{ $key }}][asistencia]"
                            value="true">
                        <input type="hidden" name="asistencias[{{ $key }}][horario_clase_id]" value="{{ $horario->id }}">
                    @endforeach
            </table>
            <button class="btn boton float-right" id="subir">SUBIR</button>
            </form>
        @else
            <br>
            <br>
            <br>
            <br>
            <br>
            @if ($llenado)
                <h4 class="text-center  textoBlanco">LA PLANILLA YA FUE LLENADA</h4>
            @else
                <h4 class="text-center textoBlanco">NO HAY HORARIOS</h4>
            @endif
        @endif
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
@endsection
