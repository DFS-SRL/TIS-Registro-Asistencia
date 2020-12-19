@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container mt-4">
        <h1 class="textoBlanco">@yield('tipoUsuario')</h1>
        @yield('usuarios')
    </div>
@endsection