@extends('layouts.master')

@section('title', 'Lista de Materias')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
            <div class="row">
                <div class="col-10">
                    <h4 class="textoBlanco">UNIVERSIDAD MAYOR DE SAN SIMON</h4>
                <h1 class="textoBlanco">DEPARTAMENTO DE PLANIFICACION ACADEMICA</h1>
                </div>
            </div>
            <div class="container mt-4">
                <table id="facultades" class="table table-responsive">
                    @forelse ($facultades as $facultad)
                    <tr id="materia{{ $facultad->id }}">
                        <td class="col-9">
                            <a href="/facultades/{{ $facultad->id }}">{{ $facultad->nombre }}</a>
                        </td>
                        <td class="col"></td>
                        <td class="col-3"><input 
                                {{-- id = {{"botonEliminar".$horario->id}} --}}
                                width="30rem" height="30rem" 
                                type="image" name="botonEliminar" 
                                src="/icons/eliminar.png" alt="Eliminar"
                                onclick="confirmarEliminarFacultad({{ $facultad->id }});">
                            <form id="eliminar-facultad{{$facultad->id}}" class="d-none" method="POST"
                                action="/facultades/{{$facultad->id}}">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                        <h3 class="textoBlanco">NO EXISTEN FACULTADES REGISTRADAS</h3>
                    @endforelse
                    <tr id="facultadNueva"><tr>
                </table>
                
            </div>
            <button type="button" class="btn boton ml-2" onclick="añadirFacultad();">AÑADIR FACULTAD <svg width="2em" height="2em"
                viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg></button>
            <br>
            <button class="btn boton float-right" id="regresar" onclick="window.location.href='/facultades'">REGRESAR</button>
        </div>

    </div>
    
    <form id="guardar-facultad" class="d-none" method="POST"
            action="/facultades/guardar">
        @csrf  
        <input  type="hidden" name="activo" value="true" required>
        <input id="nombreFacultadNueva" type="hidden" name="nombre" required>
        <input type="hidden" name="encargado_codSis" id="encargado" required>
        <input type="hidden" name="decano_codSis" id="decano" required>
        <input type="hidden" name="director_codSis" id="director" required>
    </form>
@endsection
@section('script-footer')

<script>
// funcion para confirmacion de la eliminacion de un horarioClase
    function confirmarEliminarFacultad(facultadId) {
        if (confirm("¿Estás seguro de eliminar esta facultad?"))
            document.getElementById("eliminar-facultad" + facultadId).submit();
    }
    
    function añadirFacultad(){
        $("#facultadNueva").append(`<td class="col-9">
                                        <label for="iFacultadNueva"><strong>Nombre de la facultad:</strong></label>
                                        <input type="text" name="" id="iFacultadNueva" required> <br>
                                        <label for="iEncargado"><strong>Codigo sis encargado Facultativo:</strong></label>
                                        <input type="text" name="" id="iEncargado" required><br>
                                        <label for="iDecano"><strong>Codigo sis decano:</strong></label>
                                        <input type="text" name="" id="iDecano" required><br>
                                        <label for="iDirector"><strong>Codigo director academico:</strong></label>
                                        <input type="text" name="" id="iDirector" required>
                                    </td>
                                    <td class="col-2">
                                        <input width="30rem" height="30rem" type="image" src="/icons/aceptar.png"
                                        alt="Aceptar" onclick="confirmarAñadirFacultad()">
                                    </td>
                                    <td class="col-1">
                                        <input width="30rem" height="30rem" type="image" name="botonCancelar" src="/icons/cancelar.png"
                                        alt="Cancelar" onclick = "cancelarFila()">
                                    </td>`);
    }
    function cancelarFila(){
        document.getElementById("facultadNueva").innerHTML ="";
    }
    function confirmarAñadirFacultad(){
        document.getElementById("nombreFacultadNueva").value = document.getElementById("iFacultadNueva").value;
        document.getElementById("encargado").value = document.getElementById("iEncargado").value;
        document.getElementById("decano").value = document.getElementById("iDecano").value;
        document.getElementById("director").value = document.getElementById("iDirector").value;
        document.getElementById("guardar-facultad").submit();
    }
</script>    
@endsection
