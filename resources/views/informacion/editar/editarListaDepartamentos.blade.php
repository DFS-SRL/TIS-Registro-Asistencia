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
                    <h3 class="textoBlanco">FACULTAD: {{ $facultad->nombre }}</h3>
                    <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                    <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                    <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3>
                </div>
            </div>
            <div class="container mt-4">
                <table id="departamentos" class="table table-responsive">
                    @forelse ($departamentos as $departamento)
                    <tr id="materia{{ $departamento->id }}">
                        <td class="col-9">
                            <a href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a>
                        </td>
                        <td class="col"></td>
                        <td class="col-3"><input 
                                {{-- id = {{"botonEliminar".$horario->id}} --}}
                                width="30rem" height="30rem" 
                                type="image" name="botonEliminar" 
                                src="/icons/eliminar.png" alt="Eliminar"
                                onclick="confirmarEliminarDepartamento({{ $departamento->id }});">
                            <form id="eliminar-departamento{{$departamento->id}}" class="d-none" method="POST"
                                action="/departamento/{{$departamento->id}}">
                                @csrf @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                        <h3 class="textoBlanco">ESTA FACULTAD NO TIENE REGISTRADO NINGUN DEPARTAMENTO</h3>
                    @endforelse
                    <tr id="departamentoNuevo"><tr>
                </table>
                
            </div>
            <button type="button" class="btn boton ml-2" onclick="añadirDepartamento();">AÑADIR DEPARTAMENTO <svg width="2em" height="2em"
                viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path fill-rule="evenodd"
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg></button>
            <br>
            <button class="btn boton float-right" id="regresar" onclick="window.location.href='../{{$facultad->id}}/'">REGRESAR</button>
        </div>

    </div>
    
    <form id="guardar-departamento" class="d-none" method="POST"
            action="/departamento/guardar">
        @csrf  
        <input  type="hidden" name="activo" value="true" required>
        <input id="nombreDepartamentoNuevo" type="hidden" name="nombre" required>
        <input type="hidden" name="jefe_codSis" id="jefe" required>
        <input type="hidden" name="facultad_id" value="{{$facultad->id}}" required>
    </form>
@endsection
@section('script-footer')

<script>
// funcion para confirmacion de la eliminacion de un horarioClase
    function confirmarEliminarDepartamento(departamentoId) {
        if (confirm("¿Estás seguro de eliminar este departamento?"))
            document.getElementById("eliminar-departamento" + departamentoId).submit();
    }
    
    function añadirDepartamento(){
        $("#departamentoNuevo").append(`<td class="col-9">
                                        <label for="iDepartamentoNuevo"><strong>Nombre del departamento:</strong></label>
                                        <input type="text" name="" id="iDepartamentoNuevo" required> <br>
                                        <label for="iJefeDept"><strong>Codigo sis Jefe de departamento:</strong></label>
                                        <input type="text" name="" id="iJefeDept" required><br>
                                    </td>
                                    <td class="col-2">
                                        <input width="30rem" height="30rem" type="image" src="/icons/aceptar.png"
                                        alt="Aceptar" onclick="confirmarAñadirDepartamento()">
                                    </td>
                                    <td class="col-1">
                                        <input width="30rem" height="30rem" type="image" name="botonCancelar" src="/icons/cancelar.png"
                                        alt="Cancelar" onclick = "cancelarFila()">
                                    </td>`);
    }
    function cancelarFila(){
        document.getElementById("departamentoNuevo").innerHTML ="";
    }
    function confirmarAñadirDepartamento(){
        document.getElementById("nombreDepartamentoNuevo").value = document.getElementById("iDepartamentoNuevo").value;
        document.getElementById("jefe").value = document.getElementById("iJefeDept").value;
        document.getElementById("guardar-departamento").submit();
    }
</script>    
@endsection
