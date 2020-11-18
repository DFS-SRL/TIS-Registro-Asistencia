@extends('layouts.master')
@section('title', 'informacion docente')
@include('layouts.flash-message')
@section('content')
    <div class="container">
      <div class="text-white">
        <h3>Facultad: {{ $unidad->facultad }}</h3>
        <h3>Departamento: {{ $unidad->nombre }}</h3>
        <h1 class="text-center">Información de Docente</h1>
        <h4>Nombre: {{ $usuario->nombre }}</h4>
        <h4>Codigo SIS: {{ $unidad->codSis }}</h4>
      </div>
        <div class="accordion" id="accordionExample">
            <div class="card mostaza" {{-- style="background-color: #7C7365" --}}>
              <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <b>GRUPOS</b>
                  </button>
                </h2>
              </div>
          
              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">      
                <table class="table">
                    <tbody>  
                        @foreach ($gruposActuales as $grupoActual)
                            <tr>
                                <td><a href="#{{-- /materia/{{ $materia->id }} --}}">{{$grupoActual}}</a></td>
                                <td>grupo: <a href="#{{-- {{route('grupo.informacion',$grupoActivo->grupo_id)}} --}}">{{$grupoActual->grupo_id}}</a></td>
                                <td><a href="#">registro historico</a></td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table> 
              </div>
            </div>
            <div class="card mostaza" {{-- style="background-color:#7C7365" --}}>
              <div class="card-header" id="headingTwo">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <b>ASISTENCIAS</b>
                  </button>
                </h2>
              </div>
              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="card-body">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
              </div>
            </div>
    </div>
@endsection
