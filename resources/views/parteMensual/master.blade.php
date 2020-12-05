@extends('layouts.master')

@section('title', 'Parte Mensual')

@section('content')
    <div class="m-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <h2 class = "textoBlanco">PARTE MENSUAL DE ASISTENCIA</h2>
                    <h4 class = "textoBlanco">@yield('tipoParte')</h4>
                    <h4 class = "textoBlanco">{{ $unidad->facultad->nombre . " / " . $unidad->nombre }}</h4>
                    <h4 class = "textoBlanco">{{ $gestion }}</h4>
                </div>
                <div class = "col-6">
                    <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
                    <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFin}}</span>
                    @yield('select')
                </div>
            </div>
            <br>            
            {{-- @csrf
                <form  method="POST"  @yield('action') onsubmit= "return valMinAct()"> --}}
                    @yield('reporte')
                    {{-- </form>       --}}
            <button class="btn boton float-right" id="registrar" onclick="descargar()">OBTENER PDF  <svg style="padding-bottom: 0.1em" width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
              </svg></button>  
            
            <p class="text-muted">*las horas pagables y no pagables estan en funcion a las cargas horarias efectivas</p>
        </div>
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
@endsection
<script>
    function descargar(){
        window.open(window.location.href + "/descargarPDF", '_blank');
    }
</script>
