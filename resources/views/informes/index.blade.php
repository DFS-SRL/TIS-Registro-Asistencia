@extends('layouts.master')

@section('title', 'Informes')

@section('css')
    <link rel="stylesheet" href="/css/informes/semanales.css">
@endsection

@section('content')
    <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="textoBlanco">FACULTAD: {{ $unidad['facultad'] }}</h2>
                    <h2 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h2>
                    <br>
                </div>
            </div>

            <h1 class="text-white">Informes</h1>

            <div class="textoBlanco justify-content-center esquina-redondeada" style="background:#7C7365;">
                <a class="boton btn textoNegro" href="{{ route('informes.semanales', $unidad) }}">INFORMES SEMANALES</a>
                <hr>
                <div class="col-8 row justify-content-between">
                    <h4>Enviar asistencias del mes anterior a decanatura</h4>
                    <form method="POST" id="formulario" action="{{ route('informes.subir') }}">
                        @csrf
                        <input type="hidden" name="unidad_id" value="{{ $unidad->id }}">
                        <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
                        @if ($errors->any())
                            @foreach ($errors->getMessages() as $key => $error)
                                @if ($key == 'nivel1')
                                    <INPUT class="boton btn textoNegro" TYPE='submit' value='ENVIAR DE TODOS MODOS' name='delete'
                                        onClick='return confirmSubmit(true)'>
                                @endif
                            @endforeach
                        @else
                            <INPUT class="boton btn textoNegro" TYPE='submit' value='ENVIAR' name='delete' onClick='return confirmSubmit(false)'>
                        @endif
                    </form>
                </div>
            </div>
    </div>

@endsection
