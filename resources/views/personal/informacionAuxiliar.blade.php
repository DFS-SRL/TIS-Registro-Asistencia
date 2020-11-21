
@extends('layouts.master')
@section('title', 'Información Auxiliar')
@include('layouts.flash-message')
@section('css')
    <link rel="stylesheet" href="/css/informacion/informacionDocente.css">
@endsection
@section('content')
  <div class="container">
    <div class="text-white">
      <h3>Facultad: {{ $unidad->facultad }}</h3>
      <h3>Departamento: {{ $unidad->nombre }}</h3>
      <h1 class="text-center">Información de Auxiliar</h1>
      <h4>Nombre: {{ $usuario->nombre }}</h4>
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
          <div class="row justify-content-center my-2">
            <form>
              <div class="col-12 opciones esquina-redondeada">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" onclick="cambiarGrupos(true)" checked >
                  <label class="form-check-label" for="inlineRadio1">grupos actuales</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" onclick="cambiarGrupos(false)">
                  <label class="form-check-label" for="inlineRadio2">grupos antiguos</label>
                </div>
              </div>
            </form>
          </div> 
          <div id="gruposActuales">
            @if (count($gruposActuales) != 0)
              <table class="table">
                <tbody>  
                    @foreach ($gruposActuales as $grupoActual)
                        <tr>
                            <td><a href="/materia/{{$grupoActual->materia_id}}">{{$grupoActual->nombre_materia }} </a></td>
                            <td>grupo: <a href="/grupo/{{$grupoActual->grupo_id}}">{{$grupoActual->nombre_grupo}}</a></td>
                            <td><a href="">registro historico</a></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            @else
              <div class="container">
                <h4 class="textoBlanco"><b>El Auxiliar {{$usuario->nombre}} no se encuentra asignado a ningun grupo actualmente</b></h4>
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
                <h4 class="textoBlanco"><b>El Auxiliar {{$usuario->nombre}} no tiene grupos antiguos</b></h4>
              </div>
            @endif
          </div>
        </div>
      </div>
      <div class="card mostaza">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="" aria-expanded="false" aria-controls="collapseTwo" onclick="accionColapsar('collapseTwo','collapseOne','collapseThree')">
              <b>ITEMS</b>
            </button>
          </h2>
        </div>
    
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">     
          <div class="row justify-content-center my-2">
            <form>
              <div class="col-12 opciones esquina-redondeada">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option1" onclick="cambiarItems(true)" checked >
                  <label class="form-check-label" for="inlineRadio3">items actuales</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="option2" onclick="cambiarItems(false)">
                  <label class="form-check-label" for="inlineRadio4">items antiguos</label>
                </div>
              </div>
            </form>
          </div> 
          <div id="itemsActuales">
            @if (count($itemsActuales) != 0)
              <table class="table">
                <tbody>  
                    @foreach ($itemsActuales as $itemActual)
                        <tr>
                            <td><a href="/materia/{{$itemActual->materia_id}}">{{$itemActual->nombre_materia }} </a></td>
                            <td>item: <a href="/item/{{$itemActual->grupo_id}}">{{$itemActual->nombre_grupo}}</a></td>
                            <td><a href="">registro historico</a></td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
            @else
              <div class="container">
                <h4 class="textoBlanco"><b>El Auxiliar {{$usuario->nombre}} no esta asignado a ningun item actualmente</b></h4>
              </div>
            @endif 
          </div>
          <div id="itemsAntiguos" class="oculto">
            @if (count($itemsPasados) != 0)
              <table class="table">
                <tbody class="">  
                    @foreach ($itemsPasados as $itemPasado)
                        <tr>
                            <td><a href="/materia/{{$itemPasado->materia_id}}">{{$itemPasado->nombre_materia }} </a></td>
                            <td>item: <a href="/grupo/{{$itemPasado->grupo_id}}">{{$itemPasado->nombre_grupo}}</a></td>
                            <td><a href="">registro historico</a></td>
                        </tr>
                    @endforeach 
                </tbody>
              </table>
            @else
              <div class="container">
                <h4 class="textoBlanco"><b>El Auxiliar {{$usuario->nombre}} no tiene items antiguos</b></h4>
              </div>
            @endif
          </div>
        </div>
      </div>
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
        </div>
      </div>
    </div>
  </div>
  @section('script-footer')
  <script type="text/javascript" src='/js/informacion/informacionPersonalAcademico.js'></script>
  <script>
    var a = @json($asistencias);
    console.log(a);
    var asis = [];
    for(var i in a.data)
      asis.push(a.data[i]);
    console.log(asis);
    llenarTabla(asis);
  </script>
  @endsection
  {{-- <h4>items actuales</h4>
<ul>
    @if (!$itemsActuales->isempty())
        <h5>carga horaria nominal semanal de items de laboratorio: {{ $cargaHorariaNominalItems }}</h5>
        @foreach ($itemsActuales as $itemActual)
            <li>
                {{ $itemActual }}
            </li>
        @endforeach
    @endif
</ul>
<h4>items pasados</h4>
<ul>
    @foreach ($itemsPasados as $itemPasado)
        <li>
            {{ $itemPasado }}
        </li>
    @endforeach
</ul>


<h4> asistencias </h4>
<ul>
    @foreach ($asistencias as $asistencia)
        <li>
            {{ 
                "fecha: " . $asistencia->fecha . ", materia: ". $asistencia->materia->nombre 
                . ", grupo: " . $asistencia->grupo->nombre
                . ", actividad: " . $asistencia->actividad_realizada 
                . ", asistencia: " . $asistencia->asistencia 
                . ", permiso: " . $asistencia->permiso
            }}
        </li>
    @endforeach
    {{ $asistencias->links() }}
</ul> --}}
@endsection