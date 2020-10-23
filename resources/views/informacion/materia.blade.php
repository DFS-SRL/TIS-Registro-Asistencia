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
                <p>{{ $materia->unidad->facultad }}</p>
                <p>{{ $materia->unidad->nombre }}</p>
                <p>{{ $materia->nombre }}</p>
            </div>
            <div class="col-4">
                <p>Codigo: {{$materia->id}}</p>
            </div>
        </div>
        <ul class="list-group">
            @forelse ($grupos as $grupo)
                <li class="list-group-item"><a href={{"/grupo/".$grupo->id}}>{{$grupo->nombre}}</a></li>
            @empty
                <p>No hay grupos</p>
            @endforelse
        </ul>
        <button class="btn btn-success">AÑADIR GRUPO</button>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
