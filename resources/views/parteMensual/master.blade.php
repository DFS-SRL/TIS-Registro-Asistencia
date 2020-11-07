@extends('layouts.master')

@section('title', 'Planilla Mensual')

@section('content')
    <div class="m-3"> 
    <div class="row">
        <div class="col-6">
            <h2 class = "textoBlanco">PLANILLA MENSUAL DE ASISTENCIA</h2>
            <h4 class = "textoBlanco">@yield('tipoParte')</h4>
            <h4 class = "textoBlanco">{{ $unidad->facultad . " / " . $unidad->nombre }}</h4>
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
    </div>
@endsection

@section('script-footer')
    <script src="/js/main.js"></script>
@endsection
