
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/semanalDocenteEstilo.css">
    
    <title>Planilla mensual</title>
</head>
<body>
    <div class="m-3">
    <div class="row">
        <div class="col-6">
            <h2 class = "textoBlanco">PLANILLA MENSUAL DE ASISTENCIA</h2>
            <h4 class = "textoBlanco">@yield('tipoParte')</h4>
            <h4 class = "textoBlanco">{{ $unidad->facultad . " / " . $unidad->nombre }}</h4>
            <h4 class = "textoBlanco">{{ $gestion }}</h4>
        </div>
        <div class = "col-6">
            <b class = "textoBlanco">DEL:: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
            <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFin}}</span>
        </div>
    </div>
    <br>
    @csrf
    <form  method="POST"  @yield('action') onsubmit= "return valMinAct()">
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
                @foreach ($parteDoc as $reporte)
                    <tr>
                        @foreach ($reporte as $key => $value)
                            <td class="border border-dark">{{$value}}</td>
                            
                        @endforeach
                     </tr>
                @endforeach
            </table>
            <strong>Total horas pagables: {{$totPagables }}</strong> <br>
            <strong>Total horas no pagables: {{$totNoPagables }}</strong> <br>
            <button class="btn btn-success" >Registrar</button>    
        </form>      
    </div>
    <script src="/js/main.js"></script>
</body>
</html>