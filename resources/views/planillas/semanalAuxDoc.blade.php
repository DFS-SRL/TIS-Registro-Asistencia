@extends('planillas/planillaSemanalMaster')
@section('action')
    action="{{ route('planillas.semanal') }}"
@endsection
@section('tipoUsuario')
    NOMBRE AUXILIAR:
@endsection
@section('onsubmit')
    onsubmit= "return validarCampos()"
@endsection