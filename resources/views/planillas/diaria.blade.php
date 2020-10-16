<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auxiliar laboratorio</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        table, th, td {
         border: 1px solid black;
        }
        #observacion, #actividad{
            border:0;
        }
    </style>
</head>


<body>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h5>PLANILLA DIARIA DE ASISTENCIA</h5>
                @if(!$horarios->isEmpty())
                    <p>NOMBRE AUXILIAR LABORATORIO: {{ $horarios[0]->asignado->nombre }}</p>
                    <p>CODSIS: {{ $horarios[0]->asignado_codSis }} </p>                
                @endif              
            </div>
            <div class="col-4">
                <p>DIA: {{ $horarios[0]->dia }} </p>
                <p>FECHA: {{ $fecha }} </p>
            </div>
        </div>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">HORARIO</th>
                <th scope="col">CARGO</th>
                <th scope="col">ACTIVIDAD REALIZADA</th>
                <th scope="col">OBSERVACIONES</th>
                <th scope="col">ASISTENCIA</th>
                {{-- <th scope="col">PERMISO</th> --}}
                </tr>
            </thead>
            <tbody>
                <tr>
                @forelse ($horarios as $horario)
                    <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                    <td>{{ $horario->materia->nombre }}</td>                    
                    <td><input type="text" name="" id="actividad"></td>                    
                    <td><input type="text" name="" id="observacion"></td>                    
                    <td><div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="customSwitches"checked>
                        <label class="custom-control-label" for="customSwitches"></label>
                      </div></label>
                    </td>    
                </tr>
                @empty
                    <p>NO HAY HORARIOS</p>
                @endforelse
            </tbody>
            </table>
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>

