@extends('provicional.usuarios')
@section('tipoUsuario')
    Departamentos
@endsection

@section('usuarios')
<table>
    @forelse ($departamentos as $departamento)
    <tr>
        <td class="col-6">{{$departamento->facultad}} - {{$departamento->nombre}}</td>
        <td class="col-3">
        <a href="parteMensual/docentes/{{$departamento->id}}/2020-10-19">Reporte Docentes</a>
        </td>
        <td class="col-3">
            <a href="parteMensual/auxiliares/{{$departamento->id}}/2020-10-19">Reporte Auxiliares</a>
        </td>
    </tr>
    @empty
    <h3 class="textoBlanco">No hay departamentos registrados</h3>
    @endforelse
</table>
@endsection