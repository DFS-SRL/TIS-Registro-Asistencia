@extends('layouts.master')

@section('title', 'Partes Mensuales')

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
                <h2 class="textoBlanco">FACULTAD: {{ $unidad->facultad->nombre }}</h2>
                <h2 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h2>
                <br>
            </div>
        </div>
 
        <div class="row">
            <div class="col-12">
                <p class="textoBlanco">
                    Seleccion de mes para visualizaci&oacuten de partes mensuales
                </p>
            </div>
        </div>

        <div class="row textoBlanco justify-content-center esquina-redondeada" style="background:#7C7365;">
            <form>
                <div class="col-12 opciones espaciado esquina-redondeada">
                    <input type="radio" id="docentes" name="informe" value="docencia" checked="checked">
                    <label for="docentes">Docentes</label><br>
                    <input type="radio" id="auxiliares" name="informe" value="auxiliatura   ">
                    <label for="auxiliares">Auxiliares</label><br>
                </div>

                <div class="col-12 espaciado">
                    <div class="input-group">
                        <label for="startDate">Mes/Año:</label>
                        <input id="startDate"type="month"  required> 
                    </div>
                </div>              
                <div class="col-12 espaciado">

                    <div class="text-center">
                        <p id="rangoMes">Del __/__ al __/__</p>
                    </div>

                </div>
            </form>
        </div>

        <div class="espaciado d-flex flex-row-reverse">
            <button class="boton btn btn-success textoNegro" onclick="verParteUnidad({{$unidad['id']}})">VER PARTE MENSUAL</button>
        </div>
        
    </div>
@endsection

@section('script-footer')
    <script>
        const monthControl = document.querySelector('input[type="month"]');
        const date= new Date()
        const month=("0" + (date.getMonth() + 1)).slice(-2)
        const year=date.getFullYear()
        monthControl.value = `${year}-${month}`;

        function verParteUnidad(unidad){
            mes = document.getElementById('startDate').value;
            console.log(mes);
            //redireccionar a parte
        }
        function setRangoMes(mes) {
            // var ini = primerDiaMes.addDays(
            //     -(primerDiaMes.getDay() - 1) + (semana - 1) * 7
            // );
            // fin = ini.addDays(5);

            // var $p = $("#rangoSemana");
            // dia = fin.getDate();
            // $p[0].innerHTML =
            //     "Del " +
            //     ini.getDate() +
            //     "/" +
            //     (ini.getMonth() + 1) +
            //     " al " +
            //     fin.getDate() +
            //     "/" +
            //     (fin.getMonth() + 1);
        }
    </script>
@endsection

