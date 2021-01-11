@extends('layouts.master')

@section('title', 'Editar Materia')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
            <div class="row">
                <div class="col-md-4">
                    <h4 class="textoBlanco">
                        <a class="textoBlanco" href="/facultades/{{ $materia->unidad->facultad->id }}">
                           {{ $materia->unidad->facultad->nombre }}</a>
                   </h4>
                   <h1 class="textoBlanco"><a class="textoBlanco" href="/departamento/{{ $materia->unidad->id }}">{{ $materia->unidad->nombre }}</a></h1>
                   
                    <br>
                    <h5 class="textoBlanco"><a class="textoBlanco" href="/materia/{{ $materia->id }}">{{ $materia->nombre }}</a></h5>
                
                </div>
            </div>
            <div class="container mt-4">
                <table id="grupos" class="table table-responsive">
                    @forelse ($grupos as $grupo)
                    <tr id="grupo{{ $grupo->id }}">
                        <td class="col-9">
                            <a href="/grupo/{{ $grupo->id }}">{{ $grupo->nombre }}</a>
                        </td>
                        <td class="col"></td>
                        <td class="col-3"><input 
                                {{-- id = {{"botonEliminar".$horario->id}} --}}
                                width="30rem" height="30rem" 
                                type="image" name="botonEliminar" 
                                src="/icons/eliminar.png" alt="Eliminar"
                                onclick="confirmarEliminarGrupo({{ $grupo->id }});">
                            <form id="eliminar-grupo{{$grupo->id}}" class="d-none" method="POST"
                                action="/grupo/{{$grupo->id}}">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                        <h3 class="textoBlanco">Este materia no tiene grupos asignados</h3>
                    @endforelse
                    <tr id="grupoNuevo"><tr>
                </table>
                
            </div>
            <button type="button" class="btn boton ml-2" onclick="añadirGrupo();">AÑADIR GRUPO <svg width="2em" height="2em"
                viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg></button>
            <br>
            <button class="btn boton float-right" id="regresar" onclick="window.location.href='../{{$materia->id}}'">REGRESAR</button>
        </div>

    </div>
    
    <form id="guardar-grupo" class="d-none" method="POST"
            action="/grupo/guardar">
        @csrf  
        <input  type="hidden" name="activo" value="true">
        <input  type="hidden" name="materia_id" value="{{$materia->id}}">
        <input  type="hidden" name="unidad_id" value=" {{$materia->unidad->id}}">
        <input id="nombreGrupoNuevo" type="hidden" name="nombre">
    </form>
@endsection
@section('script-footer')

<script>
// funcion para confirmacion de la eliminacion de un grupo
    function confirmarEliminarGrupo(grupoId) {
        if (confirm("¿Estás seguro de eliminar este grupo?"))
            document.getElementById("eliminar-grupo" + grupoId).submit();
    }
    
    function añadirGrupo(){
        $("#grupoNuevo").append(`<td class="col-9">
                                        <label for="iGrupoNuevo"><strong>Nombre del grupo:</strong></label>
                                        <input type="text" name="" id="iGrupoNuevo">
                                    </td>
                                    <td class="col-2">
                                        <input width="30rem" height="30rem" type="image" src="/icons/aceptar.png"
                                        alt="Aceptar" onclick="confirmarAñadirGrupo()">
                                    </td>
                                    <td class="col-1">
                                        <input width="30rem" height="30rem" type="image" name="botonCancelar" src="/icons/cancelar.png"
                                        alt="Cancelar" onclick = "cancelarFila()">
                                    </td>`);
    }
    function cancelarFila(){
        document.getElementById("grupoNuevo").innerHTML ="";
    }
    function confirmarAñadirGrupo(){
        document.getElementById("nombreGrupoNuevo").value = document.getElementById("iGrupoNuevo").value;
        document.getElementById("guardar-grupo").submit();
    }
</script>    
@endsection
