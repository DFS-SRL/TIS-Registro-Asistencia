@extends('layouts.master')

@section('title', 'Informacion Dept')

@section('css')

@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="textoBlanco">FACULTAD: {{ $unidad->facultad->nombre }}</h3>
                <h3 class="textoBlanco">DEPARTAMENTO: {{ $unidad['nombre'] }} </h3>
                <h3 class="textoBlanco">JEFE DE DEPARTAMENTO: {{$unidad->jefe->nombre}}  </h3>                
                <br>
                <strong class="textoBlanco">INFORMACION DEL DEPARTAMENTO</strong><br><br>
                <div class="d-flex justify-content-around"> 
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/materias/{{$unidad->id}}'">MATERIAS</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/personalAcademico/{{$unidad->id}}'" >PERSONAL ACADEMICO</button>
                    <button class="boton btn btn-success textoNegro" onclick="window.location.href='/partes/mensuales/{{$unidad->id}}'">BUSCAR PARTE MENSUAL</button>
                </div>
                <br><strong class="textoBlanco">ULTIMOS PARTES MENSUALES</strong><br>
                <div >
                    <table class = "table " id="ultimosPartes">
                            <tr>
                                <td class="border border-dark"><strong ></strong></td>
                                <td class="border border-dark"><a href="">Ver parte docentes</a></td>
                                <td class="border border-dark"><a href="">Ver parte auxiliares</a></td>
                            </tr>
                            <tr>
                                <td class="border border-dark"><strong></strong></td>
                                <td class="border border-dark"><a href="">Ver parte docentes</a></td>
                                <td class="border border-dark"><a href="">Ver parte auxiliares</a></td>
                            </tr>
                            <tr>
                                <td class="border border-dark"><strong></strong></td>
                                <td class="border border-dark"><a href="">Ver parte docentes</a></td>
                                <td class="border border-dark"><a href="">Ver parte auxiliares</a></td>
                            </tr>
                            <tr>
                                <td class="border border-dark"><strong></strong></td>
                                <td class="border border-dark"><a href="">Ver parte docentes</a></td>
                                <td class="border border-dark"><a href="">Ver parte auxiliares</a></td>
                            </tr>
                            <tr>
                                <td class="border border-dark"><strong></strong></td>
                                <td class="border border-dark"><a href="">Ver parte docentes</a></td>
                                <td class="border border-dark"><a href="">Ver parte auxiliares</a></td>
                            </tr>
                    </table>       
                    <input id="meses" type="month" style="display: none">
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('script-footer')
    <script>
        const monthControl = document.getElementById('meses');
        const date= new Date()
        const month=("0" + (date.getMonth() + 1)).slice(-2)
        const year=date.getFullYear()
        monthControl.value = `${year}-${month}`;
        let fechaParte = "";
        function getNombreMes() {
            añoMesSplit = monthControl.value.split("-");
            let fecha = new Date(añoMesSplit[0],añoMesSplit[1]-1,16);
            let options = {
                month: 'long',
            };
            mesString = fecha.toLocaleDateString('es-MX', options).toUpperCase();
            return mesString;
        }
        llenarTablaPartes();
        function llenarTablaPartes(){
            var table = document.getElementById("ultimosPartes");
            for (var i = 0, row; row = table.rows[i]; i++) { 
                row.cells[0].firstChild.innerText = getNombreMes();
                row.cells[1].firstChild.href ="/parteMensual/docentes/"+{{$unidad->id}}+"/"+ monthControl.value+"-16"
                row.cells[2].firstChild.href ="/parteMensual/auxiliares/"+{{$unidad->id}}+"/"+ monthControl.value+"-16"
                monthControl.stepDown();
            }            
        }
    </script>
@endsection

