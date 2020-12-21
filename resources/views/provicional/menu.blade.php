@extends('layouts.master')

@section('title', 'Menu Provicional')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <h2 class="font-weight-bold text-white">
            @if (auth()->check())
                Bienvenido {{Auth::user()->usuario->nombre()}}
            @elseif (auth()->guest()) 
                Bienvenido usuario que no ha hecho login aun :v
            @endif
        </h2>
        <a href="docentes">Docentes</a><br>
        <a href="auxiliaresDoc">Auxiliares de docencia</a><br>
        <a href="auxiliaresLabo">Auxiliares de laboratorio</a><br>
        {{-- <a href="encargadosAsist">Encargados de asistencias</a><br> --}}
        <a href="departamentos">Departamentos</a><br>
    </div>
@endsection