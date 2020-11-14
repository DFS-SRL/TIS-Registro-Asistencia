@extends('layouts.master')
@section('title', 'Buscar personal academico')

@section('content')
<div class="container">
    <div class="mx-3 my-4">
        <div class="row">
            <div class="col-md-4">
                <h4 class="textoBlanco">{{ $facultad }}</h4>
                <h1 class="textoBlanco">{{ $nombreUnidad }}</h1>
            </div>
            <div class="col-md-5">
                <form class="form-inline my-2 my-lg-0"  {{-- method="GET" action="{{ route('personalAcademico.buscar') }}" --}}>
                    <input class="form-control" type="search" placeholder="buscar personal academico"aria-label="Search" style="width:75%;" name = "nombreUsuario" maxlength="50" id="buscador" onkeypress="valLim(50, 'buscador', 'mensaje')" onkeyup="valLim(50, 'buscador', 'mensaje')">
                    <button class="btn boton my-2 my-sm-0" type="submit"><svg width="1em" height="1em"
                            viewBox="0 0 16 16" class="bi bi-search" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                            <path fill-rule="evenodd"
                                d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                        </svg>
                    </button>
                    <span id="mensaje"class="textoBlanco my-1"></span>
                </form>
            </div>
        </div>
        <br>
        <h3 class="textoBlanco"> <u>PERSONAL ACADEMICO</u></h3>
    </div>
</div>    
@section('script-footer')
    <script src="/js/main.js"></script>
@endsection
@endsection