const { partition } = require("lodash");

function confirmarGuardarHorario() {
    document.getElementById("horaFinS").value =
        document.getElementById("horaFin").value + ":00";
    document.getElementById("horaInicioS").value =
        document.getElementById("horaInicio").value + ":00";
    document.getElementById("diaS").value = document.getElementById(
        "dia"
    ).value;
    document.getElementById("rolId").value = document.getElementById(
        "tipoAcademico"
    ).value;
    if (confirm("¿Estás seguro de guardar esta porción de horario?"))
        document.getElementById("guardar-horario").submit();
}
let numFilas = document.getElementById("cuerpo-tabla").rows.length;

function vistaGrupo(id) {
    location.href = "/grupo/" + id;
}
function añadirHorario() {
    $("#cuerpo-tabla").append(
        `<tr id="` +
        numFilas +
        `">
            <td class="border border-dark">
                
                <select name ="dia" id= "dia"> 
                    <option value="LUNES">LUNES</option>
                    <option value="MARTES">MARTES</option>
                    <option value="MIERCOLES">MIERCOLES</option>
                    <option value="JUEVES">JUEVES</option>
                    <option value="VIERNES">VIERNES</option>
                    <option value="SABADO">SABADO</option>
                    </select>
                    hora inicio:
                    <input type="time" name="hora_inicio" id="horaInicio" onchange="setHoraFin()" required>
                    hora fin:
                    <input type="time" name="hora_fin" id="horaFin" disabled>
                    periodos:
                    <input type="number" id="periodo" min="1" max="12" value="1" onchange="setHoraFin()">
                    </td>
                    <td class="border border-dark">
                        <select id="tipoAcademico" name="rol_id">
                            <option value="3">DOCENCIA</option>
                            <option value="2">AUXILIATURA</option>
                            </select>
                            </td>
                            <td class="border border-dark">
                                <input width="30rem" height="30rem" type="image" src="/icons/aceptar.png" alt="Aceptar" onclick="confirmarGuardarHorario()">
                                
                                <input width="30rem" height="30rem" type="image" name="botonCancelar" src="/icons/cancelar.png" alt="Cancelar" onclick = "cancelarFila(` +
        numFilas +
        `); activar()">
                                </td>
                                </tr>`
    );
    numFilas++;
}
function cancelarFila(id) {
    fila = document.getElementById(id);
    padre = fila.parentNode;
    padre.removeChild(fila);
}
function setHoraFin(horarioId = "", esMateria = true) {
    var timeInicio = document.getElementById("horaInicio" + horarioId).value;
    var periodo = 45;
    if (!esMateria) periodo = 60;
    var numPeriodos = parseInt(
        document.getElementById("periodo" + horarioId).value
    );
    var splitTimeInicio = timeInicio.split(":");
    var horaFin = parseInt(splitTimeInicio[0]);
    var minutosFin = parseInt(splitTimeInicio[1]);

    if (timeInicio != "") {
        for (var i = numPeriodos; i > 0; i--) {
            if (minutosFin + periodo >= 60) {
                minutosFin = minutosFin + periodo - 60;
                horaFin = horaFin + 1;
            } else {
                minutosFin = minutosFin + periodo;
            }
        }
        if (horaFin < 10) {
            horaFin = "0" + horaFin;
        }
        if (minutosFin < 10) {
            minutosFin = "0" + minutosFin;
        }
        document.getElementById("horaFin" + horarioId).value =
            horaFin + ":" + minutosFin;
    }
}

/**
 * Habilita las opciones para editar la informacion de un horario
 * Funciona tanto para grupos como para horarios
 */
function camposEdicionHorarioDeGrupo(horarioId, horario) {
    var esMateria = true;
    if (horario['rol_id'] == 1) esMateria = false;

    // Vaciamos los elementos de la fila y añadimos las opciones
    $("#horario" + horarioId + ", #dia" + horarioId)
        .children("p")
        .hide();

    if (esMateria) {
        $("#horario" + horarioId).append(
            '<select id="dias' + horarioId + '"></select>'
        );
    } else {
        $("#dia" + horarioId).append(
            '<select id="dias' + horarioId + '"></select>'
        );
    }
    var dias = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
    dias.forEach((dia) => {
        $("#dias" + horarioId).append(
            '<option value="' + dia + '">' + dia + "</option>"
        );
        if (dia == horario["dia"]) {
            $("#dias" + horarioId + " :last-child").prop(
                "selected",
                "selected"
            );
        }
    });

    $("#horario" + horarioId).append(
        '<input class="ml-1" type="time" id="horaInicio' +
        horarioId +
        '" value="' +
        horario["hora_inicio"].substring(0, 5) +
        '" onchange="setHoraFin(' +
        horarioId + ', ' + esMateria +
        ')"></input>'
    );
    $("#horario" + horarioId).append(
        '<input class="ml-1" type="time" id="horaFin' +
        horarioId +
        '" value="' +
        horario["hora_fin"].substring(0, 5) +
        '" disabled></input>'
    );

    // Obtenemos la diferencia entre la hora de inicio y la hora fin
    // y asignamos esa diferencia a los periodos
    var splitTimeInicio = horario["hora_inicio"].split(":");
    var horaInicio = parseInt(splitTimeInicio[0]);
    var minutosInicio = parseInt(splitTimeInicio[1]);

    var splitTimeFin = horario["hora_fin"].split(":");
    var horaFin = parseInt(splitTimeFin[0]);
    var minutosFin = parseInt(splitTimeFin[1]);

    var periodos = horaFin * 60 + minutosFin - horaInicio * 60 - minutosInicio;
    if (esMateria) periodos /= 45;
    else periodos /= 60;

    $("#horario" + horarioId).append(
        '<input class="ml-1" type="number" name="" id="periodo' +
        horarioId +
        '" min="1" max="12" value="' +
        periodos +
        '" onchange="setHoraFin(' +
        horarioId + ', ' + esMateria +
        ')">'
    );

    $("#cargo" + horarioId)
        .children("p")
        .hide();
    $("#cargo" + horarioId).append(
        '<select id="cargos' + horarioId + '"></select>'
    );
    $("#cargos" + horarioId).append(
        '<option value="DOCENCIA">DOCENCIA</option>'
    );
    $("#cargos" + horarioId).append(
        '<option value="AUXILIATURA">AUXILIATURA</option>'
    );
    if (horario["rol_id"] == 3)
        $("#cargos" + horarioId + " :first-child").prop("selected", "selected");
    else $("#cargos" + horarioId + " :last-child").prop("selected", "selected");

    $("#botonEditar" + horarioId).hide();
    $("[id^=botonEditar]").prop("disabled", true);
    $("[id^=botonEliminar]").prop("disabled", true);
    $("#botonEliminar" + horarioId).prop("disabled", false);

    $(
        "<input id = botonAceptar" +
        horarioId +
        ' width="30rem" height="30rem" type="image" name="botonAceptar"' +
        ' src="/icons/aceptar.png" alt="Aceptar"onclick="aceptarEdicionHorarioDeGrupo(' +
        horarioId +
        ')">'
    ).insertBefore("#botonEliminar" + horarioId);

    $(
        "<input id = botonCancelar" +
        horarioId +
        ' width="30rem" height="30rem" type="image" name="botonCancelar"' + 
        ' src="/icons/cancelar.png" alt="Cancelar"onclick="cancelarEdicionHorarioDeGrupo(' +
        horarioId +
        '); activar()">'
    ).insertBefore("#botonEliminar" + horarioId);
}

/**
 * Cancela la edicion de un horario
 */
function cancelarEdicionHorarioDeGrupo(horarioId) {
    // Eliminamos los elemtnos para editar horario y mostramos los que tienen informacion
    $("#horario" + horarioId)
        .children("p")
        .show();
    $("#dia" + horarioId)
        .children("p")
        .show();
    $("#horario" + horarioId + " :not(:first-child)").remove();
    $("#dia" + horarioId + " :not(:first-child)").remove();

    $("#cargo" + horarioId)
        .children("p")
        .show();
    $("#cargo" + horarioId + " :not(:first-child)").remove();

    $("#botonEditar" + horarioId).show();
    $("[id^=botonEditar]").prop("disabled", false);
    $("[id^=botonEliminar]").prop("disabled", false);
    $("#botonAceptar" + horarioId).remove();
    $("#botonCancelar" + horarioId).remove();
}

/**
 * Aceptar la edicion del horario enviando el form
 */
function aceptarEdicionHorarioDeGrupo(horarioId) {
    // Llenamos el form de actualizacion con los datos ingresados
    $("#horaInicioForm" + horarioId).val($("#horaInicio" + horarioId).val());
    $("#horaFinForm" + horarioId).val($("#horaFin" + horarioId).val());
    $("#diaForm" + horarioId).val(
        $("#dias" + horarioId + " option:selected").text()
    );
    var rol;
    if ($("#cargos" + horarioId + " option:selected").text() == "AUXILIATURA") {
        rol = 2;
    } else {
        rol = 3;
    }
    if (!$("#cargos" + horarioId).length ) {
        rol = 1;
    } 
    $("#rolIdForm" + horarioId).val(rol);

    document.getElementById("editar-horario" + horarioId).submit();
}