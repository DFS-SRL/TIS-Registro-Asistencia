@extends('personal.informacionMaster')
@section('title', 'Información Docente')
@section('tipoPersonal','Docente')
@section('script-footer')
  <script type="text/javascript" src='/js/asistencias.js'></script>
  <script type="text/javascript" src='/js/informacion/informacionPersonalAcademico.js'></script>
  <script>
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
@endsection