@extends('layouts.master')

@section('title', 'Lista de Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
    <link rel="stylesheet" href="/css/informacion/personalAcademico.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
                <h3 class="textoBlanco">FACULTAD: <a class="textoBlanco" href="/facultades/{{ $facultad->id }}">{{ $facultad->nombre }}</a></h3>
                <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3>  
            <div class="container mt-4">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item tab-item">
                        <a class="nav-link active" id="departamentos-tab" data-toggle="tab" href="#departamentos" role="tab" aria-controls="departamentos"
                            aria-selected="true">DEPARTAMENTOS</a>
                    </li>
                    <li class="nav-item tab-item">
                        <a class="nav-link" id="mesesPartes-tab" data-toggle="tab" href="#mesesPartes" role="tab" aria-controls="mesesPartes"
                            aria-selected="false">PARTES MENSUALES</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <table class="table table-bordered table-responsive">
                        <div class="tab-pane fade show active" id="departamentos" role="tabpanel" aria-labelledby="departamentos-tab">
                            <div id="departamentos-content">
                                <ul class="list-group">
                                    @forelse ($departamentos as $departamento)
                                        <li class="list-group-item linkMateria lista"><a
                                                href="/departamento/{{ $departamento->id }}">{{ $departamento->nombre }}</a></li>
                                    @empty
                                        <h3>ESTA FACULTAD NO TIENE REGISTRADO NINGUN DEPARTAMENTO</h3>
                                    @endforelse
                                </ul>
                            </div>
                            {{ $departamentos->links() }}
                        </div>
                        <div class="tab-pane fade" id="mesesPartes" role="tabpanel" aria-labelledby="mesesPartes-tab">
                            <div id="mesesPartes-content">
                                <ul class="list-group">
                                    @forelse ($mesesPartes as $mesPartes)
                                        <li class="list-group-item linkMateria lista"><a
                                                href="/facultades/{{$facultad->id}}/{{ $mesPartes->año }}-{{ $mesPartes->mes }}">{{ $mesPartes->mes }} - {{ $mesPartes->año }}</a></li>
                                    @empty
                                        <h5>NO EXISTEN PARTES MENSUALES REGISTRADOS</h5>
                                    @endforelse
                                </ul>
                            </div>
                            {{ $departamentos->links() }}
                        </div>
                        
                    </table>

                </div>
                <br>
                <button class="btn boton" id="añadirHorario" onclick="añadirHorario(); desactivar()">AÑADIR DEPARTAMENTO
                    <svg width="2em" height="2em"
                        viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path fill-rule="evenodd"
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                </button>

            </div>
        </div>
    </div>
@endsection
@section('script-footer')
 <script>
 </script>
@endsection
