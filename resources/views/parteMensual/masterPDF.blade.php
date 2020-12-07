
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
        margin: 5px;
    }
    
    td {
        border-collapse: collapse;
        border-style: solid;
    }
    .pieDeFirmasT  {
        width: 55rem;   
        align-self: center;
        padding-left: 5rem;
    }
    .pieDeFirmas{
        border: 1px white;
        width: 100px;
        word-wrap: break-word;
        text-align: center;                
        vertical-align: text-top;
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
    @yield('reporte') <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table class="pieDeFirmasT">
        <tr >
            <td class="pieDeFirmas">
                {{$unidad->facultad->encargado->nombre }} <br> 
                Encargado Facultativo de {{$unidad->facultad->nombre}}
            </td>
            <td class="pieDeFirmas">
                {{$unidad->facultad->directorAcademico->nombre }} <br> 
                Director Academico DPA
            </td>
            <td class="pieDeFirmas">
                {{$unidad->facultad->decano->nombre }} <br> 
                Decano de la {{$unidad->facultad->nombre}}
            </td>
            <td class="pieDeFirmas">
                {{$unidad->jefe->nombre}} <br>
                Jefe de Departamento de {{$unidad->nombre}}
            </td>
        </tr>
    </table>
    
    
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = Font_Metrics::get_font("helvetica", "bold");
            $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        }
    </script>