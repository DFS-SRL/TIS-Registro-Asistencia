@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <h1 class="textoBlanco">@yield('tipoUsuario')</h1>
    <div class="container mt-4">
            @yield('usuarios')
    </div>
@endsection