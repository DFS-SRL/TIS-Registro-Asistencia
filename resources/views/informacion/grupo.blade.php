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
                @if ($docente != null)
                    <p>Docente: {{$docente->nombre}}}}</p>                    
                    <p>Carga horaria docente: {{$horarios->where('asignado_codSis', '=', $docente->codSis)->count()}}</p>
                @else
                    <p>Docente no asignado</p>
                @endif
                @if ($auxiliar != null)
                    <p>Auxiliar: {{$auxiliar->nombre}}</p>
                    <p>Carga horaria auxilliar: {{$horarios->where('asignado_codSis', '=', $auxiliar->codSis)->count()}}</p>
                @else
                    <p>Auxiliar no asignado</p>
                @endif
            </div>
        </div>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
