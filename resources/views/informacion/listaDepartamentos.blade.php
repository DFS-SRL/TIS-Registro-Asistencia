@extends('layouts.master')

@section('title', 'Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
            <div class="row">
                <h1 class="textoBlanco">UNIVERSIDAD MAYOR DE SAN SIMON</h4>
            </div>
            <div class="container mt-4">
                <ul class="list-group">
                    @forelse ($departamentos as $departamento)
                        <li class="list-group-item linkMateria lista"><a
                                href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a></li>
                    @empty
                        <h3 class="textoBlanco">NO EXISTEN FACULTADES REGISTRADAS</h3>
                    @endforelse
                    <div class="mt-3">
                        {{ $departamentos->links() }}
                    </div>
                </ul>
            </div>
        </div>
    </div>
@endsection
