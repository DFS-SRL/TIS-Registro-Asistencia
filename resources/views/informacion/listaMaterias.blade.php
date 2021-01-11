@extends('layouts.master')

@section('title', 'Lista de Materias')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="textoBlanco">{{ $unidad->facultad->nombre }}</h4>
                    <h1 class="textoBlanco">{{ $unidad->nombre }}</h1>
                </div>
                <div class="col-md-5">
                <br>
                    <form class="form-inline my-2 my-lg-0">
                        <input id="buscador" class="form-control" type="search" placeholder="buscar materia"
                            aria-label="Search">
                        <button class="btn boton my-2 my-sm-0" type="submit"><svg width="1em" height="1em"
                                viewBox="0 0 16 16" class="bi bi-search" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                <path fill-rule="evenodd"
                                    d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                            </svg></button>
                    </form>
                </div>
                @esJefeDepartamento($unidad->id)
                <div class="col-md-3">
                    <button type="button" class="btn boton my-3" onclick="window.location.href='{{ $unidad->id }}/editar';">EDITAR<svg
                            width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg></button>
                </div>
                @endesJefeDepartamento
            </div>
            <div class="container mt-4">
                <ul class="list-group">
                    @forelse ($materias as $materia)
                        <li class="list-group-item linkMateria lista"><a
                                href="/materia/{{ $materia->id }}">{{ $materia->nombre }}</a></li>
                    @empty
                        <h3 class="textoBlanco">Este unidad no tiene materias asignadas</h3>
                    @endforelse
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $materias->links() }}
                    </div>
                </ul>
            </div>
        </div>
    </div>
@endsection
