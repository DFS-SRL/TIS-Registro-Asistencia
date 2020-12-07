
@extends('layouts.master')
@include('layouts.flash-message')
@section('css')
    <link rel="stylesheet" href="/css/informacion/informacionDocente.css">
@endsection
@section('content')
  <div class="container-fluid">
    <div class="text-white">
      {{-- <h3>Facultad: {{ $unidad->facultad->nombre }}</h3> --}}
      {{-- <h3>Departamento: {{ $unidad->nombre }}</h3> --}}
      <h1 class="text-center">Información de @yield('tipoPersonal')</h1>
      {{-- <h4>Nombre: {{ $usuario->nombre() }}</h4> --}}
      <h4>Codigo SIS: {{ $usuario->codSis }}</h4>
    </div>
    <div class="accordion" id="accordionExample">
      <div class="card mostaza">
        <div class="card-header " id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="" aria-expanded="true" aria-controls="collapseOne" onclick="accionColapsar('collapseOne','collapseTwo','collapseThree')">
              <b>GRUPOS</b>
            </button>
          </h2>
        </div>
    
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">     
          <div class="card-body">
            <div class="row justify-content-center">
              <form>
                <div class="col-12 opciones esquina-redondeada">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" onclick="cambiarGrupos(true)" checked >
                    <label class="form-check-label" for="inlineRadio1">Grupos actuales</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" onclick="cambiarGrupos(false)">
                    <label class="form-check-label" for="inlineRadio2">Grupos antiguos</label>
                  </div>
                </div>
              </form>
            </div> 
            <div id="gruposActuales">
              @if (count($gruposActuales) != 0)
                <h4 class="textoBlanco m-2">Carga horaria nominal: {{$cargaHorariaNominalGrupos}} </h4>
                <table class="table">
                  <tbody>  
                      @foreach ($gruposActuales as $grupoActual)
                          <tr>
                              <td><a href="/materia/{{$grupoActual->materia_id}}">{{$grupoActual->nombre_materia }} </a></td>
                              <td>grupo: <a href="/grupo/{{$grupoActual->grupo_id}}">{{$grupoActual->nombre_grupo}}</a></td>
                              <td><a href="#">registro historico</a></td>
                          </tr>
                      @endforeach
                  </tbody>
                </table>
              @else
                <div class="container">
                  <h4 class="textoBlanco"><b>El @yield('tipoPersonal') {{$usuario->nombre()}} no se encuentra asignado a ningun grupo actualmente</b></h4>
                </div>
              @endif 
            </div>
            <div id="gruposAntiguos" class="oculto">
              @if (count($gruposPasados) != 0)
                <table class="table">
                  <tbody class="">  
                      @foreach ($gruposPasados as $grupoPasado)
                          <tr>
                              <td><a href="/materia/{{$grupoPasado->materia_id}}">{{$grupoPasado->nombre_materia }} </a></td>
                              <td>grupo: <a href="/grupo/{{$grupoPasado->grupo_id}}">{{$grupoPasado->nombre_grupo}}</a></td>
                              <td><a href="">registro historico</a></td>
                          </tr>
                      @endforeach 
                  </tbody>
                </table>
              @else
                <div class="container">
                  <h4 class="textoBlanco"><b>El @yield('tipoPersonal') {{$usuario->nombre()}} no tiene grupos antiguos</b></h4>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      @yield('items')
      <div class="card mostaza">
        <div class="card-header" id="headingThree">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="" aria-expanded="false" aria-controls="collapseThree" onclick="accionColapsar('collapseThree','collapseTwo','collapseOne')">
              <b>ASISTENCIAS</b>
            </button>
          </h2>
        </div>
      
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
          <div class="card-body" id="asistencias-content">
            
          </div>
          <div class="container">
            {{ $asistencias->links() }}
          </div>
          <button id="excepcionButton" class="btn btn-success boton cafe m-3" style=" float: right;">
            @yield('tipoPlanilla')
          </button>
        </div>
      </div>
    </div>
    
  </div>
  <meta name="csrf-token" content="{{csrf_token()}}">
@endsection


<script>

    function activar() {
        asis.forEach(elem => {
            editar = document.getElementById("botonEditar" + elem.id);
            editar.disabled = false;
            editar.src = "/icons/editar.png";
            permisoEdicion = document.getElementById("permisoEdicion" + elem.id);
            permisoEdicion.style.display = "block";            
            permisoEdicion.disabled = false;
        });
        
    }
    function desactivar() {
        asis.forEach(elem => {
            editar = document.getElementById("botonEditar" + elem.id);
            editar.disabled = true;
            editar.src = "/icons/editarDis.png";                        
            permisoEdicion = document.getElementById("permisoEdicion" + elem.id);
            permisoEdicion.disabled = true;
 
        });      
    }
</script>
<script src="/js/main.js"></script>