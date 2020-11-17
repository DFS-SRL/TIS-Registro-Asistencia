@extends('layouts.master')

@section('title', 'Editar Item')

@section('css')
    <link rel="stylesheet" href="/css/estiloEditarGrupo.css">
@endsection

@section('content')
    
    <div class="mx-3 my-4">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h2 class="textoBlanco" >{{ $item->unidad->facultad }}</h4>
                        <h2 class="textoBlanco">{{ $item->unidad->nombre }}</h1>
                            <h4 class="textoBlanco">{{ $item ->materia->nombre}}</h4>
                            <br>
                            <h4 class="textoBlanco">{{ $item->nombre }}</h4>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="textoBlanco border border-dark" scope="col">DIA</th>
                        <th class="textoBlanco border border-dark" scope="col">HORARIO</th>
                        <th class="textoBlanco border border-dark" scope="col">OPCIONES</th>
                    </tr>
                </thead>
                <tbody id="cuerpo-tabla">
                    @forelse($horarios as $key => $horario)
                        <tr>
                            <td id={{"dia".$horario->id}} class="border border-dark">
                                <p>{{ $horario->dia }}</p>
                            </td>
                            <td id={{"horario".$horario->id}} class="border border-dark">
                                <p>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</p>
                            </td>
                            <td id={{"opciones".$horario->id}} class="border border-dark">
                                <input 
                                    id = {{"botonEditar".$horario->id}}
                                    width="30rem"
                                    height="30rem"
                                    type="image"
                                    name="botonEditar" 
                                    src="/icons/editar.png" 
                                    alt="Editar"
                                    onclick="camposEdicionHorarioDeGrupo({{$horario->id}}, {{$horario}}); desactivar()"
                                >
                                <input 
                                    id = {{"botonEliminar".$horario->id}}
                                    width="30rem" height="30rem" 
                                    type="image" name="botonEliminar" 
                                    src="/icons/eliminar.png" alt="Eliminar"
                                    onclick="confirmarEliminarHorario({{ $horario->id }})">
                                <form id="editar-horario{{ $horario->id }}" class="d-none" method="POST"
                                    action="{{ route('horarioClase.actualizar', $horario) }}">
                                    @csrf @method('PATCH')
                                    <input type="number" name="unidad_id" value="{{ $item->unidad->id }}">
                                    <input type="number" name="materia_id" value="{{ $item->materia->id }}">
                                    <input type="number" name="grupo_id" value="{{ $item->id }}">
                                    <input id="horaInicioForm{{ $horario->id }}" type="time" name="hora_inicio">
                                    <input id="horaFinForm{{ $horario->id }}" type="time" name="hora_fin">
                                    <input id="diaForm{{ $horario->id }}" type="text" name="dia">
                                    <input id="rolIdForm{{ $horario->id }}" type="number" name="rol_id">
                                </form>
                                <form id="eliminar-horario{{ $horario->id }}" class="d-none" method="POST"
                                    action="{{ route('horarioClase.eliminar', $horario) }}">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <h5 class="textoBlanco">NO HAY HORARIOS</h5>
                    @endforelse
                </tbody>
            </table>

            <button class="btn boton" id="añadirHorario" onclick="añadirHorario(false); desactivar()">AÑADIR TURNO
                <svg width="2em" height="2em"
                    viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                    <path fill-rule="evenodd"
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                </svg>
            </button>
            <div class="row rounded-lg" id="personalAcademico">

                <div class="col-12">
                    @if ($horarios != null && $horarios->where('rol_id', '<=', 1)->count() > 0)
                        @if ($auxiliar != null)
                            <h4>Auxiliar: {{ $auxiliar->nombre }}
                                <input width="30rem" height="30rem" type="image"
                                    name="botonEliminar" id="desasignarAuxiliar"
                                    src="/icons/eliminar.png" alt="Eliminar" onclick="confirmarDesasignarAuxiliar('{{ $auxiliar->nombre }}')">
                                    <form id="desasignar-auxiliar" class="d-none" method="POST"
                                        action="{{ route('grupo.desasignar.auxiliarLaboratorio', $item) }}">
                                        @csrf @method('PATCH')
                                    </form>
                            </h4>
                            <h4>Carga horaria auxilliar: {{ $cargaHorariaAuxiliar }} </h4>

                        @else
                            <h4>Auxiliar: <button class="btn boton" id="asignarAuxiliar"
                                    onclick="botonAsignar('asignarAuxiliar','botonBuscador2','buscador2','cancelar2','msgObsAuxiliar',true), desactivar()">ASIGNAR
                                    AUXILIAR</button>
                                <form method="POST" action="{{ route('item.asignar.auxLabo') }}" class="form-inline my-2 my-lg-0 d-inline" onsubmit="return validarBusquedaAsignar('buscador2','msgObsAuxiliar')">
                                    @csrf @method('PATCH')
                                    <input id="buscador2" class="oculto " type="search" placeholder="codSis auxiliar"
                                        aria-label="Search" name="codSis">
                                    <button id="botonBuscador2" class="btn boton my-2 my-sm-0 oculto" type="submit"><svg
                                            width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search"
                                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                            <path fill-rule="evenodd"
                                                d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                                        </svg>
                                    </button>
                                    <input type="hidden" name = 'grupo_id' value = '{{$item->id}}'>
                                </form>
                                <button id="cancelar2" class="btn btn-danger oculto"
                                    onclick="botonAsignar('asignarAuxiliar','botonBuscador2','buscador2','cancelar2','msgObsAuxiliar',false); activar()">
                                    <svg width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-x"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                </button>
                                <label class="text-danger" id="msgObsAuxiliar" for="buscador2"></label>
                            </h4>
                            <div id="prueba">

                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <button class="btn boton float-right" id="regresar" onclick="vistaGrupo({{ $item->id }})">REGRESAR</button>
        </div>
    </div>
    <form id="guardar-horario" class="d-none" method="POST"
        action="{{ route('horarioClase.guardar') }}">
        @csrf  
        <input id="unidadId" type="hidden" name="unidad_id" value="{{$item->unidad->id}}">
        <input id="materiaId" type="hidden" name="materia_id" value="{{$item->materia->id}}">
        <input id="grupoId" type="hidden" name="grupo_id" value="{{$item->id}}">
        <input id="horaInicioS" type="hidden" name="hora_inicio">
        <input id="horaFinS" type="hidden" name="hora_fin">
        <input id="diaS" type="hidden" name="dia">
        <input id="rolId" type="hidden" name="rol_id">
    </form>
@endsection

@section('script-footer')
    <script>
        function desactivar() {
            @foreach($horarios as $key => $horario)
            eliminar = document.getElementById("botonEliminar" + {{ $horario-> id}});
            eliminar.disabled = true;
            eliminar.src = "/icons/eliminarDis.png";
        
            editar = document.getElementById("botonEditar" + {{ $horario-> id}});
            editar.disabled = true;
            editar.src = "/icons/editarDis.png";
            @endforeach
        
            document.getElementById("añadirHorario").disabled = true;
        
            nuevo = document.getElementById("asignarAuxiliar");
            if (nuevo)
                nuevo.disabled = true
        
        
            eliminar = document.getElementById("desasignarAuxiliar");
            if (eliminar) {
                eliminar.disabled = true;
                eliminar.src = "/icons/eliminarDis.png";
            }
        }

        function activar() {
            @foreach($horarios as $key => $horario)
            eliminar = document.getElementById("botonEliminar" + {{ $horario-> id}});
            eliminar.disabled = false;
            eliminar.src = "/icons/eliminar.png";

            editar = document.getElementById("botonEditar" + {{ $horario-> id}});
            editar.disabled = false;
            editar.src = "/icons/editar.png";
            @endforeach

            document.getElementById("añadirHorario").disabled = false;

            nuevo = document.getElementById("asignarAuxiliar");
            if (nuevo)
                nuevo.disabled = false;


            eliminar = document.getElementById("desasignarAuxiliar");
            if (eliminar) {
                eliminar.disabled = false;
                eliminar.src = "/icons/eliminar.png";
            }
        }
    </script>
    <script src="/js/main.js"></script>
    <script src="/js/informacion/editar.js"></script>
@endsection
