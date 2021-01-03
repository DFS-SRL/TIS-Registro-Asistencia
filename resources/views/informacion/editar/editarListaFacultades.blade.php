@extends('layouts.master')

@section('title', 'Lista de Facultades')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
            <div class="row">
                    <h4 class="textoBlanco">UNIVERSIDAD MAYOR DE SAN SIMON</h4>
                <h1 class="textoBlanco">DEPARTAMENTO DE PLANIFICACION ACADEMICA</h1>
            </div>
            <div class="container mt-4">
                <ul class="list-group">
                    @forelse ($facultades as $facultad)
                        <li class="list-group-item linkMateria lista"><a
                                href="/facultades/{{ $facultad->id }}">{{ $facultad->nombre }}</a></li>
                    @empty
                        <h3 class="textoBlanco">NO EXISTEN FACULTADES REGISTRADAS</h3>
                    @endforelse
                    <div class="mt-3">
                        {{ $facultades->links() }}
                    </div>
                </ul> 
            <button class="btn boton" id="añadirHorario" onclick="añadirHorario(); desactivar()">AÑADIR FACULTAD
                <svg width="2em" height="2em"
                    viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path fill-rule="evenodd"
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
            </button>
            </div>

        </div>
    </div>
@endsection
