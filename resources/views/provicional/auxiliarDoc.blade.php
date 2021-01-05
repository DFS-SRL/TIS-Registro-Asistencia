@extends('layouts.master')

@section('title', 'Aux. Docencia')

@section('css')
    <link rel="stylesheet" href="/css/informes/semanales.css">
@endsection

@section('content')
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="textoBlanco">NOMBRE: {{ $usuario->nombre() }}</h2>
                    <h2 class="textoBlanco">CODIGO SIS: {{ $usuario->codSis }} </h2>
                    <br>
                </div>
            </div>

            <h1 class="text-white">Operaciones Auxiliar de Docencia</h1>

            <div class="textoBlanco justify-content-center esquina-redondeada" style="background:#7C7365;">
                <a class="boton btn textoNegro" href="{{ route('informes.semanales.personal', $usuario) }}">INFORMES PASADOS</a>
                <hr>
                <a class="boton btn textoNegro" href="{{ route('planillas.semanal.auxdoc', $usuario) }}">LLENAR PLANILLA SEMANAL</a>
            </div>
    </div>

@endsection
