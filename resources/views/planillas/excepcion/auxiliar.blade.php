@extends('planillas.excepcion.excepcionMaster')
@section('tipo_academico', 'AUXILIAR')
@section('action')
    action="{{ route('planillas.semanal') }}"
@endsection
@section('onsubmit')
    onsubmit= "return validarCampos()"
@endsection
@section('tipoCargo', 'MATERIA/CARGO')
@section('tipoGrupo', 'GRUPO/ÍTEM')