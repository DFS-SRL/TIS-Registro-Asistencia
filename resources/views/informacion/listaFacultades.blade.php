@extends('layouts.master')

@section('title', 'Lista de Facultades')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
            <div class="row">
                <div class="col-10 ">
                    <h1 class="textoBlanco">UNIVERSIDAD MAYOR DE SAN SIMON</h1>
                <h4 class="textoBlanco">LISTA DE FACULTADES</h4>
                </div>
                <div class="col-2">
                    <a href="{{ route('facultades.editar') }}">
                        <button type="button" class="btn btn-primary boton my-3 textoNegro">EDITAR <svg
                                width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                            </svg></button>
                    </a>
                </div> 
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
