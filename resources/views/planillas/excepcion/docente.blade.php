@extends('planillas.excepcion.excepcionMaster')
@section('tipo_academico', 'DOCENTE')
@section('action')
    action="{{ route('planillas.semanal') }}"
@endsection
@section('onsubmit')
    onsubmit= "return valMinAct()"
@endsection
@section('tipoCargo', 'MATERIA')
@section('tipoGrupo', 'GRUPO')