@extends('provicional.usuarios')
@section('tipoUsuario')
    Departamentos
@endsection

@section('usuarios')
<table>
    @forelse ($departamentos as $departamento)
    <tr>
        <td class="col-2">{{$departamento->facultad}} - {{$departamento->nombre}}</td>
        <td class="col-1">
        <a href="parteMensual/docentes/{{$departamento->id}}/2020-10-27">Parte Docentes</a>
        </td>
        <td class="col-1">
            <a href="parteMensual/auxiliares/{{$departamento->id}}/2020-10-27">Parte Auxiliares</a>
        </td>
        <td class="col-2">
            <a href="/materias/{{$departamento->id}}">Materias</a>
        </td>  
        <td class="col-2">
            <a href="/cargos/{{$departamento->id}}">Cargos de Laboratorio</a>
        </td>        
        <td class="col-2">
            <a href="{{ route('informes', $departamento->id )}}">Informes</a>
        </td>
        <td class="col-2">
            <a href="{{ route('informacion.personalAcademico', $departamento->id )}}">Personal Academico</a>
        </td>
    </tr>
    @empty
    <h3 class="textoBlanco">No hay departamentos registrados</h3>
    @endforelse
</table>
@endsection