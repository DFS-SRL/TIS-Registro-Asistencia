<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Auxiliar Docencia</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <style>
        table, th, td {
         border: 1px solid black;
        }
        input{
            text-align: center;
        }
    </style>
</head>


<body>
    @if(!$horarios->isEmpty())
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h5>PLANILLA SEMANAL DE ASISTENCIA</h5>
                    <p>NOMBRE AUXILIAR DOCENCIA: {{ $nombre }}</p>
                    <p>CODSIS: {{ $codSis }} </p>         
            </div>
            <div class="col-4">
                <p>DESDE: {{ $fechaInicio }} </p>
                <p>HASTA: {{ $fechaFinal }} </p>
            </div>
        </div>
        @forelse ($horarios as $key1 => $unidad)
            <br>
            <h4 class = "textoBlanco">{{$unidad[0]->unidad->facultad}} / {{$unidad[0]->unidad->nombre}}</h4>
            <form>
                @csrf
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col">FECHA</th>
                        <th scope="col">HORARIO</th>
                        <th scope="col">GRUPO</th>
                        <th scope="col">MATERIA</th>
                        <th scope="col">ACTIVIDAD REALIZADA</th>
                        <th scope="col">OBSERVACIONES</th>
                        <th scope="col">ASISTENCIA</th>
                        <th scope="col">PERMISO</th>
                        </tr>
                    </thead>
                    @foreach ($unidad as $key2 => $horario)
                        <tr>
                            <td class="border border-dark">{{ $fechasDeSemana[$horario->dia] }}</td>
                            <td class="border border-dark">{{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                            <td class="border border-dark">{{ $horario->grupo->nombre }}</td>
                            <td class="border border-dark">{{ $horario->materia->nombre }}</td>
                            <td class="border border-dark"><textarea name="actividad" class ="{{$key1}}{{$key2}}" maxlength="150" disabled></textarea></td>
                            <td class="border border-dark"><textarea name="observaciones" class = "{{$key1}}{{$key2}}" maxlength="200" disabled></textarea></td>
                            <td class="border border-dark">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="asistencia{{$key1}}{{$key2}}" onclick='habilitarDeshabilitar(this)'/>
                                    <label class="custom-control-label" for="asistencia{{$key1}}{{$key2}}"></label>
                                </div>
                            </td>
                            <td class="border border-dark">
                                <select id="columnaPermiso-{{ $horario->materia->nombre }}-{{ $horario->grupo->nombre }}" name="asistencias[{{ $key2 }}][permiso]" disabled>
                                    <option value="LICENCIA">Licencia</option>
                                    <option value="BAJA_MEDICA">Baja medica</option>
                                    <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                                </select>
                            </td>
                            <input id='asistenciaFalse' type='hidden' value='false' name="asistencias[{{ $key2 }}][asistencia]">
                            <input type="text" name="asistencias[{{ $key2 }}][horario_clase_id]" value="{{ $horario->id }}" style="display: none;">
 
                        </tr>
                    @endforeach
                </table>
                {{-- <button class="btn btn-success">SUBIR</button>      --}}
            </form>
        @empty
            <p>usted no tiene clases asignadas</p>
        @endforelse
        
        <button class="btn btn-success">SUBIR</button>     
    </div>
    @else
    USTED NO ES AUXILIAR DE DOCENCIA 
    @endif              
</body>
<!-- jQuery and JS bundle w/ Popper.js -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
<script>
    function habilitarPermiso(a, b) {
        var checkBox = document.getElementById("asistencia-"+a+"-"+b);
        var columna = document.getElementById("columnaPermiso-"+a+"-"+b);
        if (checkBox.checked == false){
            columna.disabled = false;
        } else {
            columna.disabled = true;
            // columna.value = "LICENCIA";
        }
    }
</script>
</html>