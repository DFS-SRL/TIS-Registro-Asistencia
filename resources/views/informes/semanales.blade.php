@extends('layouts.master')

@section('title', 'Informes Semanales')

@section('css')
    <link rel="stylesheet" href="/css/informes/semanales.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker-1.9.0-dist/bootstrap-datepicker.min.css">
@endsection

@section('script-head')
    <script type="text/javascript" src='/js/bootstrap-input-spinner.js'></script>
    <script type="text/javascript" src='/js/bootstrap-datepicker-1.9.0-dist/bootstrap-datepicker.min.js'></script>
    <script type="text/javascript" src='/js/bootstrap-datepicker-1.9.0-dist/bootstrap-datepicker.es.min.js'></script>
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
 
        <div class="row">
            <div class="col-12">
                <p class="textoBlanco">
                    Seleccion de semana para visualización de informes de asistencia semanales
                </p>
            </div>
        </div>

        <div class="row textoBlanco justify-content-center esquina-redondeada" style="background:#7C7365;">
            <form>
                <div class="col-12 opciones espaciado esquina-redondeada">
                    <input type="radio" id="docente" name="informe" value="docencia">
                    <label for="docente">Docente</label><br>
                    <input type="radio" id="auxiliarDoc" name="informe" value="aux-docencia">
                    <label for="auxiliarDoc">Auxiliares de Docencia</label><br>
                    <input type="radio" id="auxLabo" name="informe" value="laboratorio">
                    <label for="auxLabo">Auxiliares de Laboratior</label>
                </div>

                <div class="col-12 espaciado">
                    <div class="input-group">
                        <label class="col-3 align-self-center" for="startDate">Mes/Año: </label>
                        <input id="sandbox-container" type="text" class="form-control col-8 ml-3"
                            data-date-end-date="0d" name="startDate">
                    </div>
                </div>

                <div class="col-12 espaciado">

                    <div class="input-group">
                        <label for="semana" class="align-self-center">Semana: </label>

                        <div class="input-group-prepend ml-3">
                            <button onclick="step(-1)" style="min-width: 2.5rem"
                                class="btn btn-decrement btn-outline-secondary btn-minus boton" type="button">
                                <strong>−</strong>
                            </button>
                        </div>

                        <input type="text" inputmode="decimal" style="text-align: center" name="semana"
                            class="form-control " placeholder="" id="inputLoop" value="" disabled>

                        <div class="input-group-append">
                            <button onclick="step(1)" style="min-width: 2.5rem"
                                class="btn btn-increment btn-outline-secondary btn-plus boton" type="button">
                                <strong>+</strong>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <p id="rangoSemana">Del __/__ al __/__</p>
                    </div>

                </div>
            </form>
        </div>

        <div class="espaciado float-right">
            <button class="boton btn btn-success textoNegro" onclick="verInforme({{$unidad['id']}})">Ver Informe</button>
        </div>

    </div>
@endsection

@section('script-footer')
    <script type="text/javascript" src='/js/informes/semanales.js'></script>
@endsection

