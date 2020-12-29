@extends('layouts.master')

@section('title', 'Lista de Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
    <link rel="stylesheet" href="/css/informacion/personalAcademico.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
                <h3 class="textoBlanco">FACULTAD: {{ $facultad->nombre }}</h3>
                <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3>  
            <div class="container mt-4">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item tab-item">
                        <a class="nav-link active" id="departamentos-tab" data-toggle="tab" href="#departamentos" role="tab" aria-controls="departamentos"
                            aria-selected="true" onclick="departamentos()">DEPARTAMENTOS</a>
                    </li>
                    <li class="nav-item tab-item">
                        <a class="nav-link" id="mesesPartes-tab" data-toggle="tab" href="#mesesPartes" role="tab" aria-controls="mesesPartes"
                            aria-selected="false" onclick="mesesPartes()">PARTES MENSUALES</a>
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
            </div>
        </div>
    </div>
@endsection
@section('script-footer')
 <script>
 </script>
@endsection
