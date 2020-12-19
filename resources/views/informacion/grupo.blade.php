@extends('layouts.master')

@section('title', 'Grupo')

@section('content')
    <div class="mx-3 my-4">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h2 class="textoBlanco">{{ $grupo->unidad->facultad->nombre }}</h4>
                        <h2 class="textoBlanco">{{ $grupo->unidad->nombre }}</h1>
                            <h4 class="textoBlanco">{{ $grupo->materia->nombre }}</h4>
                            <br>
                            <h4 class="textoBlanco">{{ $grupo->nombre }}</h4>
                </div>
                @if (auth()->user()->esJefeDepartamento(auth()->user()->usuario->codSis, $grupo->unidad->id))
                    <div class="col-4">
                        <button type="button" class="btn boton my-3" onclick="editarGrupo({{ $grupo->id }});">EDITAR<svg
                                width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                            </svg></button>
                    </div>
                @endif
            </div>
            <table class="table">
                <thead>
                    @if (!$horarios->isEmpty())
                        <tr>
                            <th class="textoBlanco border border-dark" scope="col">HORARIO</th>
                            <th class="textoBlanco border border-dark" scope="col">CARGO</th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @forelse($horarios as $key => $horario)
                        <tr>
                            <td class="border border-dark">{{ $horario->dia }} {{ $horario->hora_inicio }} -
                                {{ $horario->hora_fin }}</td>
                            <td class="border border-dark">
                                @if ($horario->rol_id === 3)
                                    DOCENCIA
                                @else
                                    AUXILIATURA
                                @endif
                            </td>
                        </tr>
                    @empty
                        <h4 class="textoBlanco text-center">NO HAY HORARIOS</h4>
                    @endforelse
                </tbody>
            </table>
            <div class="row ">
                <div class="col-12">
                    @if ($horarios != null && $horarios->where('rol_id', '=', 3)->count() > 0)
                        @if ($docente != null)
                            <h4 class="textoBlanco">Docente: 
                                <a class="textoBlanco"
                                    href="{{ route('informacion.docente', ['unidad' => $grupo->unidad_id, 'usuario' => $docente->codSis]) }}">
                                    {{ $docente->nombre() }}
                                </a>
                            </h4>
                            <h4 class="textoBlanco">Carga horaria docente: {{ $cargaHorariaDocente }}</h4>
                        @else
                            <h4 class="textoBlanco">Docente no asignado</h4>
                        @endif
                    @endif
                    @if ($horarios != null && $horarios->where('rol_id', '<=', 2)->count() > 0)
                        @if ($auxiliar != null)
                            <h4 class="textoBlanco">Auxiliar: 
                                <a class="textoBlanco"
                                    href="{{ route('informacion.auxiliar', ['unidad' => $grupo->unidad_id, 'usuario' => $auxiliar->codSis]) }}">
                                    {{ $auxiliar->nombre() }}
                                </a>
                            </h4>
                            <h4 class="textoBlanco">Carga horaria auxilliar: {{ $cargaHorariaAuxiliar }}</h4>
                        @else
                            <h4 class="textoBlanco">Auxiliar no asignado</h4>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-footer')
<script>
    function editarGrupo(id) {
        location.href = "/grupo/" + id + "/editar";
    }
</script>
@endsection
