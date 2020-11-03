<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
    <link rel="stylesheet" href="/css/estiloListaMAterias.css">
    <title>lista de materias</title>
</head>
<body>
    <div class="mx-3 my-4">
        <div class="row">
            <div class="col-md-4">
                <h4 class="textoBlanco">{{$facultad}}</h4>
                <h1 class="textoBlanco">{{$nombreUnidad}}</h1>
            </div>
            <div class="col-md-5">
                <form class="form-inline my-2 my-lg-0">
                    <input id = "buscador" class="form-control" type="search" placeholder="buscar materia" aria-label="Search">
                    <button class="btn boton my-2 my-sm-0" type="submit"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
                        <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
                      </svg></button>
                </form>
            </div>
            <div class="col-md">
                <button type="button" class="btn boton ml-2" >AÑADIR MATERIA<svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                  </svg></button>
            </div>
        </div>
        <div class="container mt-4">
            <ul class="list-group">
                @forelse ($materias as $materia)
                    <li class="list-group-item linkMateria lista"><a href="/materia/{{$materia->id}}">{{$materia->nombre}}</a></li>
                @empty
                    <h3 class="textoBlanco">Este unidad no tiene materias asignadas</h3>
                @endforelse
                <div class="mt-3">
                    {{$materias->links()}}
                </div>
            </ul>
        </div>
    </div>
</body>
</html>