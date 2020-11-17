@extends('layouts.master')

@section('title', 'Cargo Laboratorio')

@section('css')
    <link rel="stylesheet" href="/css/informacion/personalAcademico.css">
@endsection

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-8">
                <h4 class="textoBlanco">{{ $unidad['facultad'] }}</h2>
                    <h4 class="textoBlanco">{{ $unidad['nombre'] }}</h2>
                        <br>
                        <h2 class="textoBlanco">PERSONAL ACADÉMICO
                    </h4>
            </div>
            <div class="col-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search">
                    <div class="input-group-append">
                        <button class="btn btn-success d-flex align-items-center boton" type="submit">
                            <svg width="1em" height="1em" viewBox="0 0 15 15" class="bi bi-search" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                                <path fill-rule="evenodd"
                                    d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills nav-fill">
            <li class="nav-item tab-item">
                <a class="nav-link active" id="todos-tab" data-toggle="tab" href="#todos" role="tab" aria-controls="todos"
                    aria-selected="true" onclick="todos()">TODOS</a>
            </li>
            <li class="nav-item tab-item">
                <a class="nav-link" id="docentes-tab" data-toggle="tab" href="#docentes" role="tab" aria-controls="docentes"
                    aria-selected="false" onclick="docente()">DOCENTES</a>
            </li>
            <li class="nav-item tab-item">
                <a class="nav-link" id="aux-docencia-tab" data-toggle="tab" href="#aux-docencia" role="tab"
                    aria-controls="aux-docencia" aria-selected="false"
                    onclick="auxDoc()">AUX. DE DOCENCIA</a>
            </li>
            <li class="nav-item tab-item">
                <a class="nav-link" id="aux-labo-tab" data-toggle="tab" href="#aux-labo" role="tab" aria-controls="aux-labo"
                    aria-selected="false" onclick="auxLabo()">AUX. DE LABO.</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">

            <table class="table table-bordered">
                <div class="tab-pane fade show active" id="todos" role="tabpanel" aria-labelledby="todos-tab">
                    <div id="todos-content"></div>
                    {{ $todos->links() }}
                </div>
                <div class="tab-pane fade" id="docentes" role="tabpanel" aria-labelledby="docentes-tab">
                    <div id="docentes-content"></div>
                    {{ $docente->links() }}
                </div>
                <div class="tab-pane fade" id="aux-docencia" role="tabpanel" aria-labelledby="aux-docencia-tab">
                    <div id="aux-docencia-content"></div>
                    {{ $auxDoc->links() }}
                </div>
                <div class="tab-pane fade" id="aux-labo" role="tabpanel" aria-labelledby="aux-labo-tab">
                    <div id="aux-labo-content"></div>
                    {{ $auxLabo->links() }}
                </div>
            </table>
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/informacion/personalAcademico.js"></script>
    <script>
        function todos(){
            var a = @json($todos);
            var b = a.data;

            localStorage.setItem("section", "todos-tab");

            mostrarTabla('todos', b);
        }
        function docente(){
            var a = @json($docente);
            var b = a.data;

            localStorage.setItem("section", "docentes-tab");

            mostrarTabla('docentes', b);
        }
        function auxDoc(){
            var a = @json($auxDoc);
            var b = a.data;

            localStorage.setItem("section", "aux-docencia-tab");

            mostrarTabla('aux-docencia', b);
        }
        function auxLabo(){
            var a = @json($auxLabo);
            var b = a.data;

            localStorage.setItem("section", "aux-labo-tab");

            mostrarTabla('aux-labo', b);
        }
    </script>
@endsection
