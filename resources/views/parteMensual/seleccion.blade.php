@extends('layouts.master')

@section('title', 'Partes Mensuales')

@section('css')
    <link rel="stylesheet" href="/css/informes/semanales.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="textoBlanco">FACULTAD: {{ $unidad->facultad->nombre }}</h3>
                <h3 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h3>
                <h3 class="textoBlanco">JEFE DE DEPARTAMENTO: {{$unidad->jefe->nombre}}  </h3>                
                <br>
            </div>
        </div>
 
        <div class="row">
            <div class="col-12">
                <h5 class="textoBlanco">
                    Seleccion de mes para visualizaci&oacuten de partes mensuales
                </h5>
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
                    <div class="">
                        <label for="startDate">Mes/Año:</label>
                        <input id="startDate"type="month" onchange="setFechas()"required> 
                    </div>
                </div>              
                <div class="col-12 espaciado">

                    <div class="text-center">
                        <div>Del <span id="fechaIni">16/12/2020</span> al <span id="fechaFin">15/01/2021</span></div>
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
        
        let fechaParte = "";
        setFechas();
        function setFechas(){            
            mes = document.getElementById('startDate');
            fechaIniSpan = document.getElementById("fechaIni");
            fechaFinSpan = document.getElementById("fechaFin");

            fechaIni = mes.value.split("-");
            fechaIniSpan.innerHTML = "16/"+ fechaIni[1] +"/"+fechaIni[0];
           
            mes.stepUp();
            
            fechaFin = mes.value.split("-");
            fechaFinSpan.innerHTML = "15/"+ fechaFin[1] +"/"+fechaFin[0];
            
            setFechaParte(mes); 

            mes.stepDown();
        }
        function setFechaParte(mes){
            fechaParte = mes.value + "-16";
        }

        function verParteUnidad(unidad){
            docencia = document.getElementById("docentes").checked;
            if(docencia){
                tipoParte = "docentes";
            }else {
                tipoParte = "auxiliares";
            }
            window.location.href = "/parteMensual/"+tipoParte+"/"+unidad+"/"+fechaParte;
        }
    </script>
@endsection

