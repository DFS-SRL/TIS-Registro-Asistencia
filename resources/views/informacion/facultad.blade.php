@extends('layouts.master')

@section('title', 'Lista de Departamentos')

@section('css')
    <link rel="stylesheet" href="/css/estiloListaMaterias.css">
    <link rel="stylesheet" href="/css/informacion/personalAcademico.css">
@endsection

@section('content')
    <div class="container">
        <div class="mx-3 my-4">
            <div class="row">
                <div class="col-10 ">
                <h3 class="textoBlanco">FACULTAD: {{ $facultad->nombre }}</h3>
                <h3 class="textoBlanco">DECANO: {{ $facultad->decano->nombre() }} </h3>
                <h3 class="textoBlanco">DIRECTOR ACADEMICO: {{$facultad->directorAcademico->nombre()}}  </h3>  
                <h3 class="textoBlanco">ENCARGADO FACULTATIVO: {{$facultad->encargado->nombre()}}  </h3>
                </div>
                <div class="col-2">
                    <button type="button" class="btn boton my-3" onclick="">EDITAR<svg
                            width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil-fill" fill="currentColor"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                        </svg></button>
                </div> 
            </div>
            
            <div class="container mt-4">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item tab-item">
                        <a class="nav-link active" id="departamentos-tab" data-toggle="tab" href="#departamentos" role="tab" aria-controls="departamentos"
                            aria-selected="true">DEPARTAMENTOS</a>
                    </li>
                    @if (Auth::user()->usuario->tienePermisoNombre('ver partes mensuales'))
                        <li class="nav-item tab-item">
                            <a class="nav-link" id="mesesPartes-tab" data-toggle="tab" href="#mesesPartes" role="tab" aria-controls="mesesPartes"
                                aria-selected="false">PARTES MENSUALES</a>
                        </li>
                    @endif
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
            </div>
        </div>
    </div>
@endsection
@section('script-footer')
 <script>
 </script>
@endsection
