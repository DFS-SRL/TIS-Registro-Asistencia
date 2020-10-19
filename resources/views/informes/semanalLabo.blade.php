<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auxiliares laboratorios</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
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
               <h5>PLANILLA SEMANAL DE ASISTENCIA</h5>
               <p>FACULTAD/DPTO: {{ $unidad->facultad }} / {{ $unidad->nombre }}  </p>                
                          
            </div>
            <div class="col-2">
                <p>DESDE: {{ $fechaInicio }}</p>
            </div>
            <div class="col-2">                
                <p>HASTA: {{ $fechaFinal }} </p>    
            </div> 
        </div>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">CARGO</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">CODIGO SIS</th>
                    <th scope="col">FECHA</th>
                    <th scope="col">HORARIO</th>
                    <th scope="col">ACTIVIDAD REALIZADA</th>
                    <th scope="col">OBSERVACIONES</th>
                    <th scope="col">ASISTENCIA</th>
                    <th scope="col">PERMISO</th>
                    </tr>
                </thead>
                <form method="POST"  action="{{ route('planillas.diaria') }}">
                    @csrf
                    <tbody>
                        @forelse ($asistencias as $asistencia)
                            <tr>
                                <td>{{ $asistencia->materia->nombre }} </td>
                                <td>{{ $asistencia->usuario->nombre }}</td>
                                <td>{{ $asistencia->usuario->codSis }}</td>
                                <td>{{ formatoFecha($asistencia->fecha) }} </td>
                                <td>{{ $asistencia->horarioClase->hora_inicio }} - {{ $asistencia->horarioClase->hora_fin }}</td>
                                <td>{{ $asistencia->actividad_realizada }}</td>
                                <td>{{ $asistencia->observaciones }}</td>
                                <td>{{ $asistencia->asistencia ? 'SI' : 'NO' }}</td>
                                <td>{{ $asistencia->permiso ? $asistencia->permiso : 'sin permiso' }}</td>   
                            </tr>

                        @empty
                            <p>NO HAY HORARIOS</p>
                        @endforelse
                    </tbody>
                    </table>  
                    <button class="btn btn-success">SUBIR</button>        
                </form>
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