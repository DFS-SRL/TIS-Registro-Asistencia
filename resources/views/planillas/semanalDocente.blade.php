@extends('planillas/planillaSemanalMaster')
@section('action')
    action="{{ route('planillas.semanal') }}"
@endsection
@section('tipoUsuario')
    NOMBRE DOCENTE:
@endsection
@section('onsubmit')
    onsubmit= "return valMinAct()"
@endsection