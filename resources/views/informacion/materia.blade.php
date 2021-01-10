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
                    @esJefeDepartamento($materia->unidad->id)
                    <button type="button" class="btn boton my-3" onclick="window.location.href='{{ $materia->id }}/editar';">EDITAR<svg
                            width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg></button>
                    @endesJefeDepartamento
                </div>
            </div>
            <ul class="list-group">
                @forelse ($grupos as $grupo)
                    <li class="list-group-item"><a href="/grupo/{{ $grupo->id }}">{{ $grupo->nombre }}</a></li>
                @empty
                    <h3 class="textoBlanco">Este materia no tiene grupos asignados</h3>
                @endforelse
            </ul>
            <div class="float-right mt-3">
                <button class="btn boton float-right" id="regresar" onclick="window.location.href='../materias/{{ $materia->unidad->id }}'">REGRESAR</button>
            </div>
        </div>
    @endsection
