@extends('personal.informacionMaster')
@section('title', 'Información Docente')
@section('tipoPersonal','Docente')
@section('tipoPlanilla')    
  <a id="excepcion" href="{{ url('/planillas/semanal/excepcion/docente/' . $unidad->id . '/' . $usuario->codSis) }}" class="textoBlanco">
    LLENAR INFORME SEMANAL
  </a>
@endsection
@section('script-footer')
  <script type="text/javascript" src='/js/asistencias.js'></script>
  <script type="text/javascript" src='/js/informacion/informacionPersonalAcademico.js'></script>
  <script>

    $('#excepcionButton').on('click', function(){
      $('#excepcion')[0].click();
    });

    var sis = {{ $usuario->codSis }};
    var dep = {{ $unidad->id }};
    remember();
    var a = @json($asistencias);
    // console.log(a);
    var asis = a.data;
    var docente = true;
    // console.log(asis);

    // console.log(asis.length);
    llenarTabla(asis);
  </script>
@endsection


@section('script-footer')
    <script src="/js/main.js"></script>
    <script src="/js/asistencias.js"></script>
    <script>

    </script>
@endsection