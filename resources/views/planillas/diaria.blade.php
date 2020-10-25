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
    </style>
</head>


<body>
    <div class="container">
        <div class="row">            
            <div class="col-8"> 
                <h5>PLANILLA DIARIA DE ASISTENCIA</h5>
                    <p>NOMBRE AUXILIAR LABORATORIO: {{ $usuario->nombre }}</p>
                    <p>CODSIS: {{ $usuario->codSis }} </p>                
                        
            </div>
            <div class="col-4">
                <p>DIA: {{ getDia() }} </p>
                <p>FECHA: {{ $fecha }} </p>
            </div> 
        </div>
            @if (!$horarios->isEmpty())
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">HORARIO</th>
                        <th scope="col">CARGO</th>
                        <th scope="col">ACTIVIDAD REALIZADA</th>
                        <th scope="col">OBSERVACIONES</th>
                        <th scope="col">ASISTENCIA</th>
                        <th scope="col">PERMISO</th>
                        </tr>
                    </thead>
                    <form method="POST"  action="{{ route('planillas.diaria') }}" onsubmit= "return valMinAct()">
                        @csrf
                        <tbody>
                            @foreach ($horarios as $key => $horario)
                                <tr>
                                    <td>{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                                    <td>{{ $horario->materia->nombre }}</td>                    
                                    <td>
                                        <textarea class ="{{$key}} actividad" name="asistencias[{{ $key }}][actividad_realizada]" id="actividad{{$key}}" 
                                                  onkeypress="valLimAct({{$key}})" onkeyup="valLimAct({{$key}})"  maxlength="150"></textarea>
                                    <label class ="text-danger" id="msgAct{{$key}}" for="actividad{{$key}}"></label>
                                    </td> 
                                    <td>
                                        <textarea class ="{{$key}}" name="asistencias[{{ $key }}][observaciones]" id="observacion{{$key}}"
                                                  onkeypress="valLimObs({{$key}})" onkeyup="valLimObs({{$key}})" maxlength="200"></textarea>
                                        <label class ="text-danger" id="msgObs{{$key}}" for="observaciones"></label>
                                    </td>                     
                                    <td><div class="custom-control custom-switch">
                                        <input onchange="habilitarDeshabilitar({{$key}})" type="checkbox" class="custom-control-input" id="asistencia{{$key}}"checked/>
                                    <label class="custom-control-label" for="asistencia{{$key}}"></label>
                                    </div> </td>  
                                    <td >
                                    <select id="select{{$key}}" name="asistencias[{{ $key }}][permiso]" disabled>
                                            <option value="LICENCIA">Licencia</option>
                                            <option value="BAJA_MEDICA">Baja medica</option>
                                            <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                                        </select>
                                    </td>  
                                </tr>   
                                <input id='asistenciaFalse{{$key}}' type='hidden' name="asistencias[{{ $key }}][asistencia]" value="true">
                                <input type="hidden" name="asistencias[{{ $key }}][horario_clase_id]" value="{{ $horario->id }}">
                            @endforeach
                        </tbody>
                        </table>  
                        <button class="btn btn-success" id="subir">SUBIR</button>        
                    </form>
                @else
                    @if ($llenado)
                        <p>LA PLANILLA YA FUE LLENADA</p>
                    @else
                        <p>NO HAY HORARIOS</p>
                    @endif
                @endif
    </div>
</body>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="/js/main.js"></script>

</html>

