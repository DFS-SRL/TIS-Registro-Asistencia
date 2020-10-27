@extends('/parteMensual/master')
@section('tipoParte')
AUXILIARES    
@endsection
@section('select')
<br>
<br>
<br>
<label  class = "radio-inline textoBlanco "><input type="radio" name="optradio" onclick="combinado()" autocomplete="off" checked>Combinado</label>
<label  class = "radio-inline textoBlanco "><input type="radio" name="optradio" onclick="separado()" autocomplete="off">Separado</label>
@endsection
@section('reporte')
<div id="combinado">
<h4 class = "textoBlanco" >COMBINADO</h4>
<table class = "table table-bordered" >
    <tr>
        <th class = "textoBlanco border border-dark">CODIGO SIS</th>
        <th class = "textoBlanco border border-dark">NOMBRE</th>
        <th class = "textoBlanco border border-dark">CARGA HORARIA</th>
        <th class = "textoBlanco border border-dark">HORAS ASISTIDAS</th>
        <th class = "textoBlanco border border-dark">HH. CON FALTA</th>
        <th class = "textoBlanco border border-dark">HH. CON LICENCIA</th>
        <th class = "textoBlanco border border-dark">HH. CON BAJA</th>
        <th class = "textoBlanco border border-dark">HH. CON DECLARATORIA</th>
        <th class = "textoBlanco border border-dark">HH. PAGABLES</th>
        <th class = "textoBlanco border border-dark">HH. NO PAGABLES</th>
    </tr>
    @foreach($parteCombinado as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
            <td class="border border-dark">{{$value}}</td>
            
        @endforeach
        </tr>
    @endforeach
</table>
</div>
<div id="separado" style="display:none;" >
    <h4 class = "textoBlanco">AUXILIARES DE LABORATORIO</h4>
    <table class = "table table-bordered">
    <tr>
        <th class = "textoBlanco border border-dark">CODIGO SIS</th>
        <th class = "textoBlanco border border-dark">NOMBRE</th>
        <th class = "textoBlanco border border-dark">CARGA HORARIA</th>
        <th class = "textoBlanco border border-dark">HORAS ASISTIDAS</th>
        <th class = "textoBlanco border border-dark">HH. CON FALTA</th>
        <th class = "textoBlanco border border-dark">HH. CON LICENCIA</th>
        <th class = "textoBlanco border border-dark">HH. CON BAJA</th>
        <th class = "textoBlanco border border-dark">HH. CON DECLARATORIA</th>
        <th class = "textoBlanco border border-dark">HH. PAGABLES</th>
        <th class = "textoBlanco border border-dark">HH. NO PAGABLES</th>
    </tr>
    @foreach($parteLabo as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td class="border border-dark">{{$value}}</td>
        
        @endforeach
    </tr>
    @endforeach
</table>
<h4 class = "textoBlanco">AUXILIARES DE DOCENCIA</h4>
<table class = "table table-bordered">
    <tr>
        <th class = "textoBlanco border border-dark">CODIGO SIS</th>
        <th class = "textoBlanco border border-dark">NOMBRE</th>
        <th class = "textoBlanco border border-dark">CARGA HORARIA</th>
        <th class = "textoBlanco border border-dark">HORAS ASISTIDAS</th>
        <th class = "textoBlanco border border-dark">HH. CON FALTA</th>
        <th class = "textoBlanco border border-dark">HH. CON LICENCIA</th>
        <th class = "textoBlanco border border-dark">HH. CON BAJA</th>
        <th class = "textoBlanco border border-dark">HH. CON DECLARATORIA</th>
        <th class = "textoBlanco border border-dark">HH. PAGABLES</th>
        <th class = "textoBlanco border border-dark">HH. NO PAGABLES</th>
    </tr>
    @foreach($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
            <td class="border border-dark">{{$value}}</td>
            
        @endforeach
        </tr>
    @endforeach

</table>
</div>
@endsection
<script>
function combinado(){
    document.getElementById('combinado').style.display = "block";
    document.getElementById('separado').style.display = "none";
}
function separado(){
    document.getElementById('combinado').style.display = "none";
    document.getElementById('separado').style.display = "block";
}
</script>