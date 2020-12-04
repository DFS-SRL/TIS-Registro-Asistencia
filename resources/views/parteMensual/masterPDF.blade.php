<style>
    h4{
        margin:3px;
    }
    h2{
        margin: 5px;
    }    
    table{
        border-collapse:collapse;
    }
    th {
        background-color: #000000;
        color: white;        
        font: 75% sans-serif;
        border-style: solid;
        border-color: #000000;
    }
    
    td {
        border-collapse: collapse;
        border-style: solid;
    }
</style>
    <h2 class = "textoBlanco">PARTE MENSUAL DE ASISTENCIA</h2>
    <h4 class = "textoBlanco" >@yield('tipoParte')</h4>
    <h4 class = "textoBlanco">{{ $unidad->facultad->nombre . " / " . $unidad->nombre }}</h4>
    <h4 class = "textoBlanco">{{ $gestion }}</h4>
    <br>
    <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
    <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFin}}</span>
    <br>
    @yield('reporte')    
<script type="text/php">
    if (isset($pdf)) {
        $x = 250;
        $y = 10;
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = null;
        $size = 14;
        $color = array(255,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }
</script>