@extends('provicional.usuarios')
@section('tipoUsuario')
    Departamentos
@endsection

@section('usuarios')
<table>
    @forelse ($departamentos as $departamento)
    <tr>
        <td class="col-3">{{$departamento->facultad}} - {{$departamento->nombre}}</td>
        <td class="col-2">
        <a href="parteMensual/docentes/{{$departamento->id}}/2020-10-27">Reporte Docentes</a>
        </td>
        <td class="col-2">
            <a href="parteMensual/auxiliares/{{$departamento->id}}/2020-10-27">Reporte Auxiliares</a>
        </td>
        <td class="col-2">
            <a href="/materias/{{$departamento->id}}">Ver materias</a>
        </td>        
        <td class="col-2">
            <a href="/informe/labo/{{$departamento->id}}/2020-10-27">Informe semanal labo</a>
        </td>
        <td class="col-1">
            <a href="/informes/{{$departamento->id}}">Enviar asistencias</a>
        </td>
    </tr>
    @empty
    <h3 class="textoBlanco">No hay departamentos registrados</h3>
    @endforelse
</table>
@endsection