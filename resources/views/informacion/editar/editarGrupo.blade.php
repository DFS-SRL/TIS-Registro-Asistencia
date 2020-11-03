<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar grupo</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/estiloGeneral.css">
    <style>
        #personalAcademico{
            border-style: solid;
            border-color: black;
            background-color: white;
            /*padding: 1.5rem;*/
            padding-top: 1rem;
            padding-bottom: 1rem;
            padding-left: 1.5rem;
            margin-left: 5rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
            margin-right: 5rem;
        }
    </style>
</head>


<body>
    <div class="mx-3 my-4">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h2 class="textoBlanco">{{ $grupo->unidad->facultad }}</h4>
                    <h2 class="textoBlanco">{{ $grupo->unidad->nombre }}</h1>
                    <h4 class="textoBlanco">{{ $grupo->materia->nombre }}</h4>
                    <br>
                    <h4 class="textoBlanco">{{ $grupo->nombre }}</h4>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="textoBlanco border border-dark" scope="col">HORARIO</th>
                        <th class="textoBlanco border border-dark" scope="col">CARGO</th>
                        <th class="textoBlanco border border-dark" scope="col">OPCIONES</th>
                    </tr>
                </thead>
                <tbody id = "cuerpo-tabla">
                    @forelse($horarios as $key => $horario)
                        <tr>
                            <td class="border border-dark">{{ $horario->dia }} {{ $horario->hora_inicio }} - {{ $horario->hora_fin }}</td>
                            <td class="border border-dark">
                                @if ($docente != null && $horario->asignado_codSis === $docente->codSis)
                                    DOCENCIA
                                @elseif ($auxiliar != null && $horario->asignado_codSis === $auxiliar->codSis)
                                    AUXILIATURA
                                @else
                                    HORARIO NO ASIGNADO
                                @endif
                            </td>
                            <td class="border border-dark">
                                <input width="30rem" height="30rem" type="image" name="botonEditar" src="/icons/editar.png" alt="Editar">
                                <input width="30rem" height="30rem" type="image" name="botonEliminar" src="/icons/eliminar.png" alt="Eliminar">
                            </td>
                        </tr>
                    @empty
                        <h5 class="textoBlanco">NO HAY HORARIOS</h5>
                    @endforelse
                </tbody>
            </table>
            
            <button class="btn boton" id="añadirHorario" onclick="añadirHorario();">AÑADIR HORARIO</button>  
            <div class="row rounded-lg " id="personalAcademico">
                <div class="col-12" >
                    @if ($horarios != null && $horarios->where('rol_id', '=', 3)->count() > 0)
                        @if ($docente != null)
                            <h4 >Docente: {{$docente->nombre}}<input width="30rem" height="30rem" type="image" name="botonEliminar" src="/icons/eliminar.png" alt="Eliminar"></h4> 
                            <h4>Carga horaria docente: {{$cargaHorariaDocente}}</h4>
                            
                        @else
                            <h4 >Docente: <button class="btn boton" id="asignarDocente">ASIGNAR DOCENTE</button></h4> 
                        @endif
                    @endif
                    @if ($horarios != null && $horarios->where('rol_id', '<=', 2)->count() > 0)
                        @if ($auxiliar != null)
                            <h4>Auxiliar: {{$auxiliar->nombre}}<input width="30rem" height="30rem" type="image" name="botonEliminar" src="/icons/eliminar.png" alt="Eliminar"></h4>
                            <h4>Carga horaria auxilliar: {{$cargaHorariaAuxiliar}} </h4>
                            
                        @else
                            <h4 >Auxiliar: <button class="btn boton" id="asignarAuxiliar">ASIGNAR AUXILIAR</button> </h4> <input type="text" id="name" name="name" required
                            minlength="4" maxlength="8" size="10">
                        @endif
                    @endif
                </div>
            </div>
            <button class="btn boton float-right" id="regresar" onclick="vistaGrupo({{$grupo->id}})">REGRESAR</button> 
        </div>
    </div>
</body>

<script>
    let numColumnas = document.getElementById('cuerpo-tabla').rows.length;
    function vistaGrupo(id){
        location.href="/grupo/"+id;
    }
    function añadirHorario(){
        let cuerpoTabla = document.getElementById("cuerpo-tabla");
        cuerpoTabla.innerHTML += `<tr id ="`+numColumnas+`">
                                    <td class="border border-dark">
                                        <select>
                                            <option value="LUNES">LUNES</option>
                                            <option value="MARTES">MARTES</option>
                                            <option value="MIERCOLES">MIERCOLES</option>
                                            <option value="JUEVES">JUEVES</option>
                                            <option value="VIERNES">VIERNES</option>
                                            <option value="SABADO">SABADO</option>
                                        </select>
                                        <input type="time" name="" id="">
                                        <input type="time" name="" id="" disabled>
                                        <input type="number" name="" id="" min="1" max="12" value="1">
                                    </td>
                                    <td class="border border-dark">
                                        <select>
                                            <option value="DOCENCIA">DOCENCIA</option>
                                            <option value="AUXILIATURA">AUXILIATURA</option>
                                        </select>
                                    </td>
                                    <td class="border border-dark">
                                        <input width="30rem" height="30rem" type="image" name="botonAceptar" src="/icons/aceptar.png" alt="Aceptar" onclick="aceptarFila();">
                                        <input width="30rem" height="30rem" type="image" name="botonCancelar" src="/icons/cancelar.png" alt="Cancelar" onclick = "cancelarFila();">
                                    </td>
                                </tr>`;
    }
    function aceptarFila(){
        // numColumnas++;
    }
    function cancelarFila(){

        fila = document.getElementById(numColumnas);
        padre = fila.parentNode;
        padre.removeChild(fila);
    }
</script>
<!-- jQuery and JS bundle w/ Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" ></script>
</html>
