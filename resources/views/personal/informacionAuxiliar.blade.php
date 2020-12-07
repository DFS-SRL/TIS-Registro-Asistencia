@extends('personal.informacionMaster')
@section('title', 'Información Auxiliar')
@section('tipoPersonal','Auxiliar')
@section('items')
<div class="card mostaza">
  <div class="card-header" id="headingTwo">
    <h2 class="mb-0">
      <button class="btn btn-link btn-block text-left collapsed text-white" type="button" data-toggle="collapse" data-target="" aria-expanded="false" aria-controls="collapseTwo" onclick="accionColapsar('collapseTwo','collapseOne','collapseThree')">
        <b>ITEMS</b>
      </button>
    </h2>
  </div>

  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">  
    <div class="card-body">   
      <div class="row justify-content-center my-2">
        <form>
          <div class="col-12 opciones esquina-redondeada">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option1" onclick="cambiarItems(true)" checked >
              <label class="form-check-label" for="inlineRadio3">Items actuales</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4" value="option2" onclick="cambiarItems(false)">
              <label class="form-check-label" for="inlineRadio4">Items antiguos</label>
            </div>
          </div>
        </form>
      </div> 
      <div id="itemsActuales">
        @if (count($itemsActuales) != 0)
          <h4 class="textoBlanco m-2">Carga horaria nominal: {{$cargaHorariaNominalItems}} </h4>
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
            <h4 class="textoBlanco"><b>El Auxiliar {{$usuario->nombre()}} no esta asignado a ningun item actualmente</b></h4>
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
                        <td><a href="">Registro historico</a></td>
                    </tr>
                @endforeach 
            </tbody>
          </table>
        @else
          <div class="container">
            <h4 class="textoBlanco"><b>El Auxiliar {{$usuario->nombre()}} no tiene items antiguos</b></h4>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

@section('tipoPlanilla')    
  <a id="excepcion" href="{{ url('/planillas/semanal/excepcion/auxiliar/' . $unidad->id . '/' . $usuario->codSis) }}" class="textoBlanco">
    LLENAR INFORME SEMANAL
  </a>
@endsection
      
@section('script-footer')
  <script type="text/javascript" src='/js/informacion/informacionPersonalAcademico.js'></script>
  <script type="text/javascript" src='/js/asistencias.js'></script>
  <script>

    $('#excepcionButton').on('click', function(){
      $('#excepcion')[0].click();
    });

    var sis = {{ $usuario->codSis }};
    var dep = {{ $unidad->id }};
    remember();
    var a = @json($asistencias);
    // console.log(a);
    var asis = [];
    var docente = false;
    for(var i in a.data)
      asis.push(a.data[i]);
    // console.log(asis);
    llenarTabla(asis);
    console.log(sis);
    console.log(dep);
  </script>
  @endsection