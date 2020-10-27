<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Grupo</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
</head>


<body>
    <div class="mx-3 my-4">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h2 class="textoBlanco">{{ $grupo->unidad->facultad }}</h4>
                    <h2 class="textoBlanco">{{ $grupo->unidad->nombre }}</h1>
                    <h4 class="textoBlanco">{{ $grupo->materia->nombre }}</h4>
                    <h4 class="textoBlanco">{{ $grupo->nombre }}</h4>
                </div>
                <div class="col-4">
                    <button class="btn btn-primary">EDITAR</button>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th class="textoBlanco border border-dark" scope="col">HORARIO</th>
                        <th class="textoBlanco border border-dark" scope="col">CARGO</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($horarios as $key => $horario)
                        <tr>
                            <td class="border border-dark">{{ $horario->dia }} {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                            <td class="border border-dark">
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
                        <h5 class="textoBlanco">NO HAY HORARIOS</h5>
                    @endforelse
                </tbody>
            </table>
            <div class="row">
                <div class="col-12">
                    @if ($horarios != null && $horarios->where('rol_id', '=', 3)->count() > 0)
                        @if ($docente != null)
                            <h4 class="textoBlanco">Docente: {{$docente->nombre}}</h4> 
                            <h4 class="textoBlanco">Carga horaria docente: {{$cargaHorariaDocente}}</h4>
                        @else
                            <h4 class="textoBlanco">Docente no asignado</h4>
                        @endif
                    @endif
                    @if ($horarios != null && $horarios->where('rol_id', '<=', 2)->count() > 0)
                        @if ($auxiliar != null)
                            <h4 class="textoBlanco">Auxiliar: {{$auxiliar->nombre}}</h4>
                            <h4 class="textoBlanco">Carga horaria auxilliar: {{$cargaHorariaAuxiliar}}</h4>
                        @else
                            <h4 class="textoBlanco">Auxiliar no asignado</h4>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
