<style>
    h4{
        margin:5px;
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
<div class="col-6">
    <h2 class = "textoBlanco">PARTE MENSUAL DE ASISTENCIA</h2>
    <h4 class = "textoBlanco">DOCENTES</h4>
    <h4 class = "textoBlanco">{{ $unidad->facultad . " / " . $unidad->nombre }}</h4>
    <h4 class = "textoBlanco">{{ $gestion }}</h4>
</div>
<div class = "col-6">
    <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
    <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFin}}</span>
    @yield('select')
</div>
<table  cellpadding="0" cellspacing="1" bordercolor="#000000">
    <tr>
        <th>CODIGO SIS</th>
        <th>NOMBRE</th>
        <th>C. HORARIA NOMINAL</th>
        <th>C. HORARIA EFECTIVA</th>
        <th>HORAS ASISTIDAS</th>
        <th>HH. CON FALTA</th>
        <th>HH. CON LICENCIA</th>
        <th>HH. CON BAJA</th>
        <th>HH. CON DECLARATORIA</th>
        <th>HH. PAGABLES</th>
        <th>HH. NO PAGABLES</th>
    </tr>
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach    
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
    @foreach ($parteDoc as $reporte)
    <tr>
        @foreach ($reporte as $key => $value)
        <td >
                {{ $value }}
        </td>    

        @endforeach
    </tr>
    @endforeach
</table>
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