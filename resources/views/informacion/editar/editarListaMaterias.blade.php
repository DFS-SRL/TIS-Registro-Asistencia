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
                    {{-- <h4 class="textoBlanco">{{ $unidad->facultad->nombre }}</h4> --}}
                    <h1 class="textoBlanco">{{ $unidad->nombre }}</h1>
                </div>
            </div>
            <div class="container mt-4">
                <table class="table table-responsive">
                    @forelse ($materias as $materia)
                    <tr class="">
                        <td class="col ">
                            <a href="/materia/{{ $materia->id }}">{{ $materia->nombre }}</a>
                        </td>
                        <td class="col "><input 
                                {{-- id = {{"botonEliminar".$horario->id}} --}}
                                width="30rem" height="30rem" 
                                type="image" name="botonEliminar" 
                                src="/icons/eliminar.png" alt="Eliminar"
                                onclick="confirmarEliminarMateria({{ $materia->id }});">
                            <form id="eliminar-materia{{$materia->id}}" class="d-none" method="POST"
                                action="/materia/{{$materia->id}}">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                        <h3 class="textoBlanco">Este unidad no tiene materias asignadas</h3>
                    @endforelse
                </table>
                
            </div>
            <button type="button" class="btn boton ml-2">AÑADIR MATERIA <svg width="2em" height="2em"
                viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg></button>
            <br>
            <button class="btn boton float-right" id="regresar" onclick="window.location.href='../{{$unidad->id}}'">REGRESAR</button>
        </div>

    </div>
@endsection
@section('script-footer')

<script>
// funcion para confirmacion de la eliminacion de un horarioClase
    function confirmarEliminarMateria(materiaId) {
        if (confirm("¿Estás seguro de eliminar esta materia?"))
            document.getElementById("eliminar-materia" + materiaId).submit();
    }
    
</script>    
@endsection
