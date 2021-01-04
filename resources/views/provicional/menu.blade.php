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
        {{-- <a href="docentes">Docentes</a><br> --}}
        {{-- <a href="auxiliaresDoc">Auxiliares de docencia</a><br> --}}
        {{-- <a href="auxiliaresLabo">Auxiliares de laboratorio</a><br> --}}
        {{-- <a href="encargadosAsist">Encargados de asistencias</a><br> --}}
        {{-- <a href="departamentos">Departamentos</a><br> --}}
        {{-- <a href="facultades">Facultades</a><br> --}}
        <a href="reset-password">Cambia tu contraseña</a>
        <div class="container mt-4">
            <h2 class="textoBlanco">Roles:</h2>
            <ul class="list-group">
                @forelse (Auth::user()->usuario->roles as $rol)
                    <li class="list-group-item lista">
                        <a>
                            {{ $rol->nombre }}
                        </a>
                    </li>
                @empty
                    <h1 class="textoBlanco">No tiene ningun rol asignado</h1>
                @endforelse
            </ul>
        </div>
        <div class="container mt-4">
            <h2 class="textoBlanco">Permisos:</h2>
            <ul class="list-group">
                @forelse (Auth::user()->usuario->todosLosPermisos() as $permiso)
                    <li class="list-group-item lista">
                        <a>
                            {{ $permiso->nombre }}
                        </a>
                        @if ($permiso->descripcion != null)
                            <a>- {{$permiso->descripcion}}</a>
                        @endif
                    </li>
                @empty
                    <h1 class="textoBlanco">No tiene ningun permiso asignado</h1>
                @endforelse
            </ul>
        </div>
    </div>
@endsection