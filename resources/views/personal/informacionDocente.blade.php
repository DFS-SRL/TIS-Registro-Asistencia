@extends('layouts.master')
@section('title', 'informacion docente')
@include('layouts.flash-message')
@section('css')
    <link rel="stylesheet" href="/css/informacion/informacionDocente.css">
@endsection
@section('content')
  <div class="container">
    <div class="text-white">
      <h3>Facultad: {{ $unidad->facultad }}</h3>
      <h3>Departamento: {{ $unidad->nombre }}</h3>
      <h1 class="text-center">Información de Docente</h1>
      <h4>Nombre: {{ $usuario->nombre }}</h4>
      <h4>Codigo SIS: {{ $usuario->codSis }}</h4>
    </div>
    <div class="accordion" id="accordionExample">
      <div class="card mostaza">
        <div class="card-header " id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-link btn-block text-left text-white" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
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
                <h4 class="textoBlanco"><b>El docente {{$usuario->nombre}} no esta asignado a ningun grupo actualmente</b></h4>
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
                <h4 class="textoBlanco"><b>El docente {{$usuario->nombre}} no tiene grupos antiguos</b></h4>
              </div>
            @endif
          </div>
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
          <div class="card-body" id="asistencias-content">
            
          </div>
          {{ $asistencias->links() }}
        </div>
      </div>
    </div>
  </div>
  @section('script-footer')
  <script type="text/javascript" src='/js/informacion/informacionPersonalAcademico.js'></script>
  <script>
    var a = @json($asistencias);
    console.log(a);
    var asis = a.data;
    console.log(asis);

    // var asis = [];
    // for(var i in a.data)
    //   asis.push(a.data[i]);
    // console.log(asis);

    var table =
    `
    <table class="table table-bordered">
      <tr>
        <th class="textoBlanco border border-dark">MATERIA</th>
        <th class="textoBlanco border border-dark">GRUPO</th>
        <th class="textoBlanco border border-dark">FECHA</th>
        <th class="textoBlanco border border-dark">HORARIO</th>
        <th class="textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
        <th class="textoBlanco border border-dark">INDICADOR VERIFICABLE</th>
        <th class="textoBlanco border border-dark">OBSERVACIONES</th>
        <th class="textoBlanco border border-dark">ASISTENCIA</th>
        <th class="textoBlanco border border-dark">PERSMISO</th>
      </tr>
    `;
    
    asis.forEach(
      function callback(elem, index, array) {
        table += "<tr>" + 
            `<td>Materia</td>`+
            "<td>" + elem.grupo_id + "</td>" +
            "<td>" + elem.fecha + "</td>" +
            "<td>" + elem.horario_clase.hora_inicio + " - " + elem.horario_clase.hora_fin + "</td>" +
            "<td>" + cambiarTexto(elem.actividad_realizada) + "</td>" +
            "<td>" + cambiarTexto(elem.indicador_verificable) + "</td>" +
            "<td>" + cambiarTexto(elem.observaciones) + "</td>" +
            "<td>" + cambiarTexto(elem.asistencia) + "</td>" +
            "<td>" + cambiarTexto(elem.permiso) + "</td>" +
          "</tr>"
        ;
      }
    );

    table += "</table>";

    var div = $('#asistencias-content').html(table);

    function cambiarTexto(txt){
      if(txt === null)
        return "-";
      if(txt === true)
        return "SI";
      if(txt === false)
        return "NO";
      return txt;
    }
  </script>
  @endsection
@endsection