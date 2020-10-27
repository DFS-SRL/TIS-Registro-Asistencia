<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auxiliar laboratorio</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">

</head>


<body>
    <div class="container my-4">
        <div class="row">
            <div class="col-8">
                <h4 class="textoBlanco">{{ $grupo->unidad->facultad }}</h4>
                <h1 class="textoBlanco">{{ $grupo->unidad->nombre }}</h1>
                <h5 class="textoBlanco">{{ $grupo->materia->nombre }}</h5>
                <p class="textoBlanco">{{ $grupo->nombre }}</p>
            </div>
            <div class="col-4">
                <button type="button" class="btn boton my-3" >editar  <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                  </svg></button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="textoBlanco border border-dark">HORARIO</th>
                    <th scope="col" class="textoBlanco border border-dark">CARGO</th>
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
                    <p>NO HAY HORARIOS</p>
                @endforelse
            </tbody>
        </table>
        <div class="row bg-light rounded">
            <div class="col-12">
                @if ($docente != null)
                    <h5>Docente: {{$docente->nombre}}</h5>                    
                    <h5>Carga horaria docente: {{$horarios->where('asignado_codSis', '=', $docente->codSis)->count()}}</h5>
                @else
                    <h3 class="textoBlanco">Docente no asignado</h3>
                @endif
                @if ($auxiliar != null)
                    <h5>Auxiliar: {{$auxiliar->nombre}}</h5>
                    <h5>Carga horaria auxilliar: {{$horarios->where('asignado_codSis', '=', $auxiliar->codSis)->count()}}</h5>
                @else
                    <h3 class="textoBlanco">Auxiliar no asignado</h3>
                @endif
            </div>
        </div>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
