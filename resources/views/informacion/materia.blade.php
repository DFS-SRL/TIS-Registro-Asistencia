@extends('layouts.master')

@section('title', 'Materia')

@section('content')
    <div class="mx-3 my-4">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h4 class="textoBlanco">{{ $materia->unidad->facultad->nombre }}</h4>
                    <h1 class="textoBlanco">{{ $materia->unidad->nombre }}</h1>
                    <br>
                    <h5 class="textoBlanco">{{ $materia->nombre }}</h5>
                </div>
                <div class="col-4">
                    <h4 class="textoBlanco">Codigo de la materia: {{ $materia->id }}</h4>
                </div>
            </div>
            <ul class="list-group">
                @forelse ($grupos as $grupo)
                    <li class="list-group-item"><a href="/grupo/{{ $grupo->id }}">{{ $grupo->nombre }}</a></li>
                @empty
                    <h3 class="textoBlanco">Este materia no tiene grupos asignados</h3>
                @endforelse
            </ul>
            <button type="button" class="btn boton my-3">AÑADIR GRUPO <svg width="2em" height="2em" viewBox="0 0 16 16"
                    class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path fill-rule="evenodd"
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
            </button>
        </div>
    @endsection
