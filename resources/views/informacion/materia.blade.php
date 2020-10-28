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
                    <h4 class="textoBlanco">{{ $materia->unidad->facultad }}</h4>
                    <h1 class="textoBlanco">{{ $materia->unidad->nombre }}</h1>
                    <br>
                    <h5 class="textoBlanco">{{ $materia->nombre }}</h5>
                </div>
                <div class="col-4">
                    <h4 class="textoBlanco">Codigo de la materia: {{$materia->id}}</h4>
                </div>
            </div>
        <ul class="list-group">
            @forelse ($grupos as $grupo)
                <li class="list-group-item"><a href="/grupo/{{$grupo->id}}">{{$grupo->nombre}}</a></li>
            @empty
                <h3 class="textoBlanco">Este materia no tiene grupos asignados</h3>
            @endforelse
        </ul>
        <button type="button" class="btn boton my-3" >añadir grupo   <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
          </svg></button>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
