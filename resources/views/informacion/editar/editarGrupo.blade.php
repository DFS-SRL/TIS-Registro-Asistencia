@extends('layouts.master')

@section('title', 'Editar Grupo')

@section('css')
    <link rel="stylesheet" href="/css/estiloEditarGrupo.css">
@endsection

@section('content')
    
    <div class="mx-3 my-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <h2 class="textoBlanco" >{{ $grupo->unidad->facultad }}</h4>
                        <h2 class="textoBlanco">{{ $grupo->unidad->nombre }}</h1>
                            <h4 class="textoBlanco">{{ $grupo->materia->nombre }}</h4>
                            <br>
                            <h4 class="textoBlanco">{{ $grupo->nombre }}</h4>
                </div>
            </div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="textoBlanco border border-dark" scope="col">HORARIO</th>
                        <th class="textoBlanco border border-dark" scope="col">CARGO</th>
                        <th class="textoBlanco border border-dark" scope="col">OPCIONES</th>
                    </tr>
                </thead>
                <tbody id="cuerpo-tabla">
                    @forelse($horarios as $key => $horario)
                        <tr>
                            <td id={{"horario".$horario->id}} class="border border-dark">
                                <p>{{ $horario->dia }} {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</p>
                            </td>
                            <td id={{"cargo".$horario->id}} class="border border-dark">
                                <p>
                                    @if ($horario->rol_id === 3)
                                        DOCENCIA
                                    @else
                                        AUXILIATURA
                                    @endif
                                </p>
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
                                    <input type="number" name="unidad_id" value="{{ $grupo->unidad->id }}">
                                    <input type="number" name="materia_id" value="{{ $grupo->materia->id }}">
                                    <input type="number" name="grupo_id" value="{{ $grupo->id }}">
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

            <button class="btn boton" id="añadirHorario" onclick="añadirHorario(); desactivar()">AÑADIR HORARIO
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
                    @if ($horarios != null && $horarios->where('rol_id', '=', 3)->count() > 0)
                        @if ($docente != null)
                            <h4>Docente: 
                                <a class="textoNegro"
                                    href="{{ route('informacion.docente', ['unidad' => $grupo->unidad_id, 'usuario' => $docente->codSis]) }}">
                                    {{ $docente->nombre }}
                                </a>
                                <input width="30rem" height="30rem" type="image" 
                                    name="botonDesasignar" id="desasignarDocente"
                                    src="/icons/eliminar.png" alt="Desasignar"
                                    onclick="confirmarDesasignarDocente('{{ $docente->nombre }}')">
                                <form id="desasignar-docente" class="d-none" method="POST"
                                    action="{{ route('grupo.desasignar.docente', $grupo) }}">
                                    @csrf @method('PATCH')
                                </form>
                            </h4>
                            <h4>Carga horaria docente: {{ $cargaHorariaDocente }}</h4>

                        @else
                            <h4>Docente: <button class="btn boton" id="asignarDocente"
                                    onclick="botonAsignar('asignarDocente','botonBuscador1','buscador1','cancelar1','msgObsDocente',true); desactivar()">ASIGNAR
                                    DOCENTE</button>
                                <form method="POST" action="{{ route('grupo.asignar.docente') }}" id='asignar-docente'
                                    class="form-inline my-2 my-lg-0 d-inline"
                                >
                                    @csrf @method('PATCH')
                                    <input id="buscador1" class=" oculto" type="search" placeholder="codSis docente" aria-label="Search" name='codSis' >
                                    <input type="hidden" name = 'grupo_id' value = '{{$grupo->id}}'>
                                </form>
                                <input width="30rem" height="30rem" type="image" 
                                    src="/icons/aceptar.png" id="botonBuscador1" class="oculto align-middle"
                                    alt="Aceptar" onclick="validarBusquedaAsignar('buscador1','msgObsDocente', false)">
                                <input width="30rem" height="30rem" type="image" 
                                    id="cancelar1" src="/icons/cancelar.png"
                                    class="oculto align-middle"
                                    alt="Cancelar" onclick = "botonAsignar('asignarDocente','botonBuscador1','buscador1','cancelar1','msgObsDocente',false); activar()">
                                <label class="text-danger" id="msgObsDocente" for="buscador1"></label>
                            </h4>
                        @endif
                    @endif
                    @if ($horarios != null && $horarios->where('rol_id', '<=', 2)->count() > 0)
                        @if ($auxiliar != null)
                            <h4>Auxiliar: 
                                <a class="textoNegro"
                                    href="{{ route('informacion.auxiliar', ['unidad' => $grupo->unidad_id, 'usuario' => $auxiliar->codSis]) }}">
                                    {{ $auxiliar->nombre }}
                                </a>
                                <input width="30rem" height="30rem" type="image"
                                    name="botonEliminar" id="desasignarAuxiliar"
                                    src="/icons/eliminar.png" alt="Eliminar" onclick="confirmarDesasignarAuxiliar('{{ $auxiliar->nombre }}')">
                                    <form id="desasignar-auxiliar" class="d-none" method="POST"
                                        action="{{ route('grupo.desasignar.auxiliar', $grupo) }}">
                                        @csrf @method('PATCH')
                                    </form>
                            </h4>
                            <h4>Carga horaria auxilliar: {{ $cargaHorariaAuxiliar }} </h4>

                        @else
                            <h4>Auxiliar: <button class="btn boton" id="asignarAuxiliar"
                                    onclick="botonAsignar('asignarAuxiliar','botonBuscador2','buscador2','cancelar2','msgObsAuxiliar',true), desactivar()">ASIGNAR
                                    AUXILIAR</button>
                                <form method="POST" id="asignar-auxiliar"
                                    action="{{ route('grupo.asignar.auxDoc') }}" class="form-inline my-2 my-lg-0 d-inline"
                                >
                                    @csrf @method('PATCH')
                                    <input id="buscador2" class="oculto " type="search" placeholder="codSis auxiliar"
                                        aria-label="Search" name="codSis">
                                    <input type="hidden" name = 'grupo_id' value = '{{$grupo->id}}'>
                                </form>
                                <input width="30rem" height="30rem" type="image" 
                                    src="/icons/aceptar.png" id="botonBuscador2" class="oculto align-middle"
                                    alt="Aceptar" onclick="validarBusquedaAsignar('buscador2','msgObsAuxiliar', true)">
                                <input width="30rem" height="30rem" type="image" 
                                    id="cancelar2" src="/icons/cancelar.png"
                                    class="oculto align-middle"
                                    alt="Cancelar" onclick = "botonAsignar('asignarAuxiliar','botonBuscador2','buscador2','cancelar2','msgObsAuxiliar',false); activar()">
                                <label class="text-danger" id="msgObsAuxiliar" for="buscador2"></label>
                            </h4>
                            <div id="prueba">

                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <button class="btn boton float-right" id="regresar" onclick="vistaGrupo({{ $grupo->id }})">REGRESAR</button>
        </div>
    </div>
    <form id="guardar-horario" class="d-none" method="POST"
        action="{{ route('horarioClase.guardar') }}">
        @csrf  
        <input id="unidadId" type="hidden" name="unidad_id" value="{{$grupo->unidad->id}}">
        <input id="materiaId" type="hidden" name="materia_id" value="{{$grupo->materia->id}}">
        <input id="grupoId" type="hidden" name="grupo_id" value="{{$grupo->id}}">
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
        
            nuevo = document.getElementById("asignarDocente");
            if (nuevo)
                nuevo.disabled = true
            nuevo = document.getElementById("asignarAuxiliar");
            if (nuevo)
                nuevo.disabled = true
        
            eliminar = document.getElementById("desasignarDocente");
            if (eliminar) {
                eliminar.disabled = true;
                eliminar.src = "/icons/eliminarDis.png";
            }
        
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

            nuevo = document.getElementById("asignarDocente");
            if (nuevo)
                nuevo.disabled = false;
            nuevo = document.getElementById("asignarAuxiliar");
            if (nuevo)
                nuevo.disabled = false;

            eliminar = document.getElementById("desasignarDocente");
            if (eliminar) {
                eliminar.disabled = false;
                eliminar.src = "/icons/eliminar.png";
            }

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
