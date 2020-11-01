

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Planilla semanal de asistencia</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
    
</head>
<body>
    <div class="m-3">
    <div class="row">
        <div class="col-6">
            <h2 class = "textoBlanco">PLANILLA SEMANAL DE ASISTENCIA @yield('tipo_academico')</h2>
        </div>
        <div class = "col-6">
            <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
            <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFinal}}</span>
        </div>
    </div>
            <br>
            
            @if (!$asistencias->isEmpty())
            {{-- <h4 class = "textoBlanco">{{$unidad[0]->unidad->facultad}} / {{$unidad[0]->unidad->nombre}}</h4> --}}
                <table class = "table table-bordered">
                    <tr>
                        <th class = "textoBlanco border border-dark">CARGO</th>
                        <th class = "textoBlanco border border-dark">NOMBRE</th>
                        <th class = "textoBlanco border border-dark">CODIGO SIS</th>
                        <th class = "textoBlanco border border-dark">FECHA</th>
                        <th class = "textoBlanco border border-dark">HORARIO</th>
                        <th class = "textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
                        <th class = "textoBlanco border border-dark">OBSERVACIONES</th>
                        <th class =  "textoBlanco border border-dark">ASISTENCIA</th>
                        <th class = "textoBlanco border border-dark">PERMISO</th>
                    </tr>
                    @foreach ($asistencias as $asistencia)
                        <tr>
                            <td>{{ $asistencia->materia->nombre .$asistencia->grupo->nombre  }} </td>
                            <td>{{ $asistencia->usuario->nombre }} </td>
                            <td>{{ $asistencia->usuario->codSis }} </td>
                            <td>{{ formatoFecha($asistencia->fecha) }}</td>
                            <td>{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }} </td>
                            <td>{{ $asistencia->actividad_realizada }} </td>
                            <td>{{ $asistencia->observaciones }}</td>
                            <td> {{ $asistencia->asistencia ? 'SI' : 'NO' }}</td>
                            <td> {{ $asistencia->permiso ? $asistencia->permiso : '-' }} </td>
                        </tr>
                    @endforeach
                </table>
                
            @else                
                <br>
                <br>
                <br>
                <br>
                <br>
                <h4 class="text-center textoBlanco">NO HAY ASISTENCIAS REGISTRADAS</h4>
    
            @endif
    </div>
    <script src="/js/main.js"></script>
</body>
</html>