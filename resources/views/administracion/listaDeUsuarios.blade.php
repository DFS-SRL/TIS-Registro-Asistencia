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
                    <h3 class="textoBlanco">Usuarios registrados en el sistema</h3>
                </div>
            </div>
            <div class="container mt-4">
              <table class="table">
                <thead>
                  <tr>
                    <th class="textoBlanco" scope="col">Cod. SIS</th>
                    <th class="textoBlanco" scope="col">Nombre</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($usuarios as $usuario)
                  <tr>
                    <td>{{ $usuario->codSis }}</td>
                    <td><a href="{{route('asignarPermisos', $usuario)}}">{{ $usuario->nombre() }}</a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $usuarios->links() }}
              
            </div>
            
        </div>
    </div>
@endsection
