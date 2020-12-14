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
            </div>
        </div>
    </div>
@endsection
