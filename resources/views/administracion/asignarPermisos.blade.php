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
                    <h2 class="textoBlanco">Permisos para {{$usuario->nombre()}}</h2>
                </div>
            </div>
            <div class="container mt-4">
              <h4 class="textoBlanco">Permisos propios de sus roles</h4>
              <ul class="list-group">
                @forelse ($usuario->permisosDeRoles() as $permisoRol)
                <li class="list-group-item lista">
                  {{$permisoRol->nombre}}
                </li> 
                @empty
                    <h5>El usuario no tiene roles asignados</h5>
                @endforelse
              </ul>
              <h4 class="textoBlanco mt-3">Permisos del usuario</h4>
              <div class="col-12 opciones esquina-redondeada cafe">
                <form method="POST" action="{{route('actualizarPermisos', $usuario)}}">
                  @csrf
                  @foreach ($todosLosPermisos as $permiso)
                  <div class="form-check">
                    @if ($permiso->tiene)
                    <input name="{{$permiso->id}}" class="form-check-input" type="checkbox" id="permiso{{$permiso->id}}" checked>
                    @else
                    <input name="{{$permiso->id}}" class="form-check-input" type="checkbox" id="permiso{{$permiso->id}}">
                    @endif
                    <label for="permiso{{$permiso->id}}" class="form-check-label textoBlanco">
                      {{$permiso->nombre}}
                    </label>
                  </div>  
                  @endforeach
                  <button type="submit" class="btn boton mt-2 ml-2">ACTUALIZAR PERMISOS</button>
                </form>
              </div>
            </div>
            
        </div>
    </div>
@endsection
