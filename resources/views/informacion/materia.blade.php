<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Materia</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
</head>


<body>
    <div class="mx-3 my-4">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h2 class="textoBlanco">{{ $materia->unidad->facultad }}</h4>
                    <h2 class="textoBlanco">{{ $materia->unidad->nombre }}</h4>
                    <h4 class="textoBlanco">{{ $materia->nombre }}</h4>
                </div>
                <div class="col-4">
                    <h4 class="textoBlanco">Codigo: {{$materia->id}}</h4>
                </div>
            </div>
            <ul class="list-group">
                @forelse ($grupos as $grupo)
                    <li class="list-group-item lista"><a href="/grupo/{{$grupo->id}}">{{$grupo->nombre}}</a></li>
                @empty
                    <h4 class="textoBlanco">No hay grupos</h4>
                @endforelse
            </ul>
            <button class="btn btn-success">AÑADIR GRUPO</button>
        </div>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
