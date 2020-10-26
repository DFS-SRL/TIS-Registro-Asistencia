<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auxiliares laboratorios</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
    <style>
        table, th, td {
         border: 1px solid black;
        }
    </style>
</head>


<body>
    <div class="container">
        <div class="row">            
            <div class="col-8"> 
               <h2 class = "textoBlanco" >PLANILLA SEMANAL DE ASISTENCIA</h2>
               <h4 class = "textoBlanco">FACULTAD/DPTO: {{ $unidad->facultad }} / {{ $unidad->nombre }}  </h4>                
                          
            </div>
            <div class = "col-4">
                <b class = "textoBlanco">DEL: </b><span class = "textoBlanco"> {{ $fechaInicio }}</span>
                <b class = "textoBlanco ml-4">AL: </b><span class = "textoBlanco"> {{$fechaFinal}}</span>
            </div>
        </div>
        @if (!$asistencias->isEmpty())
            <table class="table">
                <tr>
                    <th class = "textoBlanco border border-dark" scope="col">CARGO</th>
                    <th class = "textoBlanco border border-dark" scope="col">NOMBRE</th>
                    <th class = "textoBlanco border border-dark" scope="col">CODIGO SIS</th>
                    <th class = "textoBlanco border border-dark" scope="col">FECHA</th>
                    <th class = "textoBlanco border border-dark" scope="col">HORARIO</th>
                    <th class = "textoBlanco border border-dark" scope="col">ACTIVIDAD REALIZADA</th>
                    <th class = "textoBlanco border border-dark" scope="col">OBSERVACIONES</th>
                    <th class = "textoBlanco border border-dark" scope="col">ASISTENCIA</th>
                    <th class = "textoBlanco border border-dark" scope="col">PERMISO</th>
                </tr>
                @foreach ($asistencias as $asistencia)
                    <tr>
                        <td class = "border border-dark">{{ $asistencia->materia->nombre }} </td>
                        <td class = "border border-dark">{{ $asistencia->usuario->nombre }}</td>
                        <td class = "border border-dark">{{ $asistencia->usuario->codSis }}</td>
                        <td class = "border border-dark">{{ formatoFecha($asistencia->fecha) }} </td>
                        <td class = "border border-dark">{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }}</td>
                        <td class = "border border-dark">{{ $asistencia->actividad_realizada }}</td>
                        <td class = "border border-dark">{{ $asistencia->observaciones }}</td>
                        <td class = "border border-dark">{{ $asistencia->asistencia ? 'SI' : 'NO' }}</td>
                        <td class = "border border-dark">{{ $asistencia->permiso ? $asistencia->permiso : 'sin permiso' }}</td>   
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
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script>
    function habilitarPermiso(id) {
        if (document.getElementById("asistencia"+id).checked == false){
            document.getElementById("columnaPermiso"+id).disabled = false;
            document.getElementById("asistenciaFalse"+id).value= false;
        } else {
            document.getElementById("columnaPermiso"+id).disabled = true;
            document.getElementById("asistenciaFalse"+id).value= true;
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>