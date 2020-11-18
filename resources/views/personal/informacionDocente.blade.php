@extends('layouts.master')
@section('title', 'informacion docente')
@include('layouts.flash-message')
@section('css')
    <link rel="stylesheet" href="/css/informacion/informacionDocente.css">
@endsection
@section('content')
    <div class="container">
      <div class="row justify-content-center">
        <form>
          <div class="col-12 opciones esquina-redondeada mb-3">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" checked>
              <label class="form-check-label" for="inlineRadio1">grupos actuales</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
              <label class="form-check-label" for="inlineRadio2">grupos antiguos</label>
            </div>
          </div>
        </form>
      </div>
        <div class="accordion" id="accordionExample">
            <div class="card mostaza">
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
                        @foreach ($gruposActivos as $grupoActivo)
                            <tr>
                                <td><a href="/materia/{{$grupoActivo->materia_id}}">{{$grupoActivo->nombre_materia }} </a></td>
                                <td>grupo: <a href="/grupo/{{$grupoActivo->grupo_id}}">{{$grupoActivo->nombre_grupo}}</a></td>
                                <td><a href="">registro historico</a></td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table> 
              </div>
            </div>
            <div class="card mostaza">
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
