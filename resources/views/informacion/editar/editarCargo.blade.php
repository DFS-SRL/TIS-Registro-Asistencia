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
                    <h4 class="textoBlanco">{{ $cargo->unidad->facultad->nombre }}</h4>
                    <h1 class="textoBlanco">{{ $cargo->unidad->nombre }}</h1>
                    <br>
                    <h5 class="textoBlanco">{{ $cargo->nombre }}</h5>
                </div>
            </div>
            <div class="container mt-4">
                <table id="grupos" class="table table-responsive">
                    @forelse ($items as $item)
                    <tr id="grupo{{ $item->id }}">
                        <td class="col-9">
                            <a href="/item/{{ $item->id }}">{{ $item->nombre }}</a>
                        </td>
                        <td class="col"></td>
                        <td class="col-3"><input 
                                {{-- id = {{"botonEliminar".$horario->id}} --}}
                                width="30rem" height="30rem" 
                                type="image" name="botonEliminar" 
                                src="/icons/eliminar.png" alt="Eliminar"
                                onclick="confirmarEliminarGrupo({{ $item->id }});">
                            <form id="eliminar-grupo{{$item->id}}" class="d-none" method="POST"
                                action="/grupo/{{$item->id}}">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                        <h3 class="textoBlanco">Este cargo no tiene items asignados</h3>
                    @endforelse
                    <tr id="grupoNuevo"><tr>
                </table>
                
            </div>
            <button type="button" class="btn boton ml-2" onclick="añadirGrupo();">AÑADIR ITEM <svg width="2em" height="2em"
                viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg></button>
            <br>
            <button class="btn boton float-right" id="regresar" onclick="window.location.href='../{{$cargo->id}}'">REGRESAR</button>
        </div>

    </div>
    
    <form id="guardar-grupo" class="d-none" method="POST"
            action="/grupo/guardar">
        @csrf  
        <input  type="hidden" name="activo" value="true">
        <input  type="hidden" name="materia_id" value="{{$cargo->id}}">
        <input  type="hidden" name="unidad_id" value=" {{$cargo->unidad->id}}">
        <input id="nombreGrupoNuevo" type="hidden" name="nombre">
    </form>
@endsection
@section('script-footer')

<script>
// funcion para confirmacion de la eliminacion de un grupo
    function confirmarEliminarGrupo(grupoId) {
        if (confirm("¿Estás seguro de eliminar este item?"))
            document.getElementById("eliminar-grupo" + grupoId).submit();
    }
    
    function añadirGrupo(){
        $("#grupoNuevo").append(`<td class="col-9">
                                        <label for="iGrupoNuevo"><strong>Nombre del item:</strong></label>
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
