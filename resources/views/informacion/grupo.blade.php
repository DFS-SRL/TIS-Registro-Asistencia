<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auxiliar laboratorio</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

    </style>
</head>


<body>
    {{-- $grupo->unidad->facultad --}}
    {{-- @if(!$horarios->isEmpty()) --}}
    <div class="container">
        <div class="row">
            <div class="col-8">
                <p>{{ $grupo->unidad->facultad }}</p>
                <p>{{ $grupo->unidad->nombre }}</p>
                <p>{{ $grupo->materia->nombre }}</p>
                <p>{{ $grupo->nombre }}</p>
            </div>
            <div class="col-4">
                <button class="btn btn-primary">EDITAR</button>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">HORARIO</th>
                    <th scope="col">CARGO</th>
                </tr>
            </thead>
            <tbody>
                @forelse($horarios as $key => $horario)
                    <tr>
                        <td>{{ $horario->dia }} {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                        <td>
                            @if ($docente != null && $horario->asignado_codSis === $docente->codSis)
                                DOCENCIA
                            @elseif ($auxiliar != null && $horario->asignado_codSis === $auxiliar->codSis)
                                AUXILIATURA
                            @else
                                HORARIO NO ASIGNADO
                            @endif
                        </td>
                    </tr>
                @empty
                    <p>NO HAY HORARIOS</p>
                @endforelse
            </tbody>
        </table>
        <div class="row">
            <div class="col-12">
                <p>Docente: {{$docente->nombre}}</p>
                
                <p>Carga horaria docente: {{$horarios->where('asignado_codSis', '=', $docente->codSis)->count()}}</p>
                <p>Auxiliar: </p>
                <p>Carga horaria auxilliar: {{$horarios->where('asignado_codSis', '=', $auxiliar->codSis)->count()}}</p>
            </div>
        </div>
    </div>
    {{-- @else
        USTED NO ES AUXILIAR DE LABORATORIO
@endif--}}
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script>
    function habilitarPermiso(id) {
        if (document.getElementById("asistencia"+id).checked == false){
            document.getElementById("columnaPermiso"+id).disabled = false;
            document.getElementById("asistenciaFalse"+id).value= false;
        } else {
            document.getElementById("columnaPermiso"+id).disabled = true;
            document.getElementById("asistenciaFalse"+id).value= true;
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
