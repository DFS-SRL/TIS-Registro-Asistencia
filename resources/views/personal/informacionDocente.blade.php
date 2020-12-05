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

    function desactivar() {
            @foreach($asistencias as $key1 => $unidad)
                // @foreach($unidad as $key2 => $asistencia)
                //     editar = document.getElementById("botonEditar" + {{ $asistencia->id }});
                //     editar.disabled = true;
                //     editar.src = "/icons/editarDis.png";
                // @endforeach
            @endforeach
        }

        function activar() {
          console.log($asistencias);
            // @foreach($asistencias as $key1 => $unidad)
            //     @foreach($unidad as $key2 => $asistencia)
            //         @if($asistencia->nivel == 1)
            //             editar = document.getElementById("botonEditar" + {{ $asistencia->id }});
            //             editar.disabled = false;
            //             editar.src = "/icons/editar.png";
            //         @endif
            //     @endforeach
            // @endforeach
        }
  </script>
@endsection
@section('script-footer')
    <script src="/js/main.js"></script>
    <script src="/js/asistencias.js"></script>
    <script>

    </script>
@endsection