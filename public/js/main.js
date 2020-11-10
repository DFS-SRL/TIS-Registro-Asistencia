/*Valida el limite de letras en actividadRealizada */
function valLimAct(codigo) {
    let textAreaAct = document.getElementById("actividad" + codigo);
    let limite = 150;
    numCaracteres = textAreaAct.value.length;
    if (numCaracteres >= limite) {
        document.getElementById("msgAct" + codigo).innerHTML =
            "L&iacutemite de caracteres alcanzado";
    } else {
        document.getElementById("msgAct" + codigo).innerHTML = "";
    }
}
/*Valida el limite de caracteres en Observaciones*/
function valLimObs(codigo) {
    let textAreaAct = document.getElementById("observacion" + codigo);
    let limite = 200;
    numCaracteres = textAreaAct.value.length;
    if (numCaracteres >= limite) {
        document.getElementById("msgObs" + codigo).innerHTML =
            "L&iacutemite de caracteres alcanzado";
    } else {
        document.getElementById("msgObs" + codigo).innerHTML = "";
    }
}
/*Valida numero minimo de caracteres para actividad realizada */
function valMinAct() {
    let res = true;
    let actividades = document.getElementsByClassName("actividad");
    for (actividad of actividades) {
        if (actividad.disabled) {
            res = res && true;
        } else {
            if (actividad.value.length < 5) {
                // console.log("Llenar campo actividad");
                id = actividad.id.replace("actividad", "");
                document.getElementById("msgAct" + id).innerHTML =
                    "N&uacutemero de caracteres insuficiente";
                // console.log(id);
                res = res && false;
            } else {
                // console.log("Llenado correctamente");
                res = res && true;
            }
        }
    }
    return res;
}

/* habilita y deshabilita los textarea y el combobox de la planilla semanal de docente dependiendo del switch del formulario*/

function habilitarDeshabilitar(codigo) {
    elementos = document.getElementsByClassName(codigo);
    select = document.getElementById("select" + codigo);

    if (elementos[0].disabled) {
        for (elemento of elementos) {
            elemento.removeAttribute("disabled");
            select.setAttribute("disabled", "");
        }
        document.getElementById("asistenciaFalse" + codigo).value = true;
    } else {
        for (elemento of elementos) {
            elemento.setAttribute("disabled", "");
            elemento.value = "";
            select.removeAttribute("disabled");
        }
        document.getElementById("msgAct" + codigo).innerHTML = "";
        document.getElementById("msgObs" + codigo).innerHTML = "";
        document.getElementById("asistenciaFalse" + codigo).value = false;
    }
}
/*deshabilita el boton de horarios si existen horarios */
function habilitarBotonRegistrar(horarios) {
    // console.log(horarios);
    if (horarios > 0) {
        document.getElementById("registrar").style.display = "block";
        // console.log("es vacio");
    }
}
/*al hacer click en boton editar de grupo materia se redirige a la vista editar */

/*habilita el campo de busqueda al precionar el boton "asignar ..." en la vista de edicion de informacion de un grupo*/
function botonAsignar(botonId, botonBuscadorId, buscadorId) {
    $("#" + botonId).hide();
    $("#" + botonBuscadorId).show();
    $("#" + buscadorId).addClass("form-control");
}

/*valida que el campo de busqueda de docentes o auxiliares   para asignar a un grupo, no este vacio y que solo contenga numeros*/
function validarBusquedaAsignar(buscadorId, msgObsId) {
    campoBusqueda = document.getElementById(buscadorId);
    let res = false;
    if (campoBusqueda.value.length == 0) {
        document.getElementById(msgObsId).innerHTML =
            "debe especificar el codSis del docente que desea asignar a este grupo";
        res = false;
    } else if (!contieneSoloNumeros(campoBusqueda.value)) {
        document.getElementById(msgObsId).innerHTML =
            "solo se permiten caracteres numéricos";
        res = false;
    } else {
        res = true;
    }
    return res;
}

function contieneSoloNumeros(texto) {
    let res = true;
    for (pos = 0; pos < texto.length && res; pos++) {
        res = texto.charCodeAt(pos) >= 48 && texto.charCodeAt(pos) <= 57;
    }
    return res;
}

/*Valida el limite de letras en actividadRealizada */
function valLimAct(codigo) {
    let textAreaAct = document.getElementById("actividad" + codigo);
    let limite = 150;
    numCaracteres = textAreaAct.value.length;
    if (numCaracteres >= limite) {
        document.getElementById("msgAct" + codigo).innerHTML =
            "L&iacutemite de caracteres alcanzado";
    } else {
        document.getElementById("msgAct" + codigo).innerHTML = "";
    }
}
/*Valida el limite de caracteres en Observaciones*/
function valLimObs(codigo) {
    let textAreaAct = document.getElementById("observacion" + codigo);
    let limite = 200;
    numCaracteres = textAreaAct.value.length;
    if (numCaracteres >= limite) {
        document.getElementById("msgObs" + codigo).innerHTML =
            "L&iacutemite de caracteres alcanzado";
    } else {
        document.getElementById("msgObs" + codigo).innerHTML = "";
    }
}
/*Valida numero minimo de caracteres para actividad realizada */
function valMinAct() {
    let res = true;
    let actividades = document.getElementsByClassName("actividad");
    for (actividad of actividades) {
        if (actividad.disabled) {
            res = res && true;
        } else {
            if (actividad.value.length < 5) {
                // console.log("Llenar campo actividad");
                id = actividad.id.replace("actividad", "");
                document.getElementById("msgAct" + id).innerHTML =
                    "N&uacutemero de caracteres insuficiente";
                // console.log(id);
                res = res && false;
            } else {
                // console.log("Llenado correctamente");
                res = res && true;
            }
        }
    }
    return res;
}

/* habilita y deshabilita los textarea y el combobox de la planilla semanal de docente dependiendo del switch del formulario*/

function habilitarDeshabilitar(codigo) {
    elementos = document.getElementsByClassName(codigo);
    select = document.getElementById("select" + codigo);

    if (elementos[0].disabled) {
        for (elemento of elementos) {
            elemento.removeAttribute("disabled");
            select.setAttribute("disabled", "");
        }
        document.getElementById("asistenciaFalse" + codigo).value = true;
    } else {
        for (elemento of elementos) {
            elemento.setAttribute("disabled", "");
            elemento.value = "";
            select.removeAttribute("disabled");
        }
        document.getElementById("msgAct" + codigo).innerHTML = "";
        document.getElementById("msgObs" + codigo).innerHTML = "";
        document.getElementById("asistenciaFalse" + codigo).value = false;
    }
}

/*habilita el campo de busqueda al precionar el boton "asignar ..." en la vista de edicion de informacion de un grupo*/
function botonAsignar(
    botonId,
    botonBuscadorId,
    buscadorId,
    cancelarId,
    msgObsId,
    ocultar
) {
    if (ocultar) {
        $("#" + botonId).hide();
        $("#" + botonBuscadorId).show();
        $("#" + buscadorId).addClass("form-control");
        $("#" + cancelarId).show();
    } else {
        $("#" + botonId).show();
        $("#" + botonBuscadorId).hide();
        $("#" + buscadorId).removeClass("form-control");
        $("#" + cancelarId).hide();
        $("#" + msgObsId).empty();
    }
}

/*valida que el campo de busqueda de docentes o auxiliares   para asignar a un grupo, no este vacio y que solo contenga numeros*/
function validarBusquedaAsignar(buscadorId, msgObsId) {
    campoBusqueda = document.getElementById(buscadorId);
    let res;
    if (campoBusqueda.value.length == 0) {
        document.getElementById(msgObsId).innerHTML =
            "debe especificar el codSis del docente que desea asignar a este grupo";
        res = false;
    } else if (!contieneSoloNumeros(campoBusqueda.value)) {
        document.getElementById(msgObsId).innerHTML =
            "solo se permiten caracteres numéricos";
        res = false;
    } else {
        res = true;
    }
    return res;
}

function contieneSoloNumeros(texto) {
    let res = true;
    for (pos = 0; pos < texto.length && res; pos++) {
        res = texto.charCodeAt(pos) >= 48 && texto.charCodeAt(pos) <= 57;
    }
    return res;
}

// funcion para confirmacion de la eliminacion de un horarioClase
function confirmarEliminarHorario(horarioId) {
    if (confirm("¿Estás seguro de eliminar esta porción de horario?"))
        document.getElementById("eliminar-horario" + horarioId).submit();
}

// funcion para confirmacion de la desasignacion de docente de un grupo
function confirmarDesasignarDocente(docente) {
    if (confirm("¿Estás seguro de desasignar al docente " + docente + "?"))
        document.getElementById("desasignar-docente").submit();
}

/**
 * Habilita las opciones para editar la informacion de un horario
 */
function camposEdicionHorarioDeGrupo(horarioId, horario) {
    // Vaciamos los elementos de la fila y añadimos las opciones
    $("#horario" + horarioId)
        .children("p")
        .hide();
    $("#horario" + horarioId).append(
        '<select id="dias' + horarioId + '"></select>'
    );
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
        horarioId +
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
    periodos /= 45;

    $("#horario" + horarioId).append(
        '<input class="ml-1" type="number" name="" id="periodo' +
        horarioId +
        '" min="1" max="12" value="' +
        periodos +
        '" onchange="setHoraFin(' +
        horarioId +
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
        ' width="30rem" height="30rem" type="image" name="botonAceptar" src="/icons/aceptar.png" alt="Aceptar"onclick="aceptarEdicionHorarioDeGrupo(' +
        horarioId +
        ')">'
    ).insertBefore("#botonEliminar" + horarioId);

    $(
        "<input id = botonCancelar" +
        horarioId +
        ' width="30rem" height="30rem" type="image" name="botonCancelar" src="/icons/cancelar.png" alt="Cancelar"onclick="cancelarEdicionHorarioDeGrupo(' +
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
    $("#horario" + horarioId + " :not(:first-child)").remove();

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
    $("#rolIdForm" + horarioId).val(rol);

    document.getElementById("editar-horario" + horarioId).submit();
}

// funcion de confirm box para subir asistencias del mes de una unidad
function confirmSubmit(fuerza) {
    var agree = confirm(
        "¿Estás seguro de subir los informes?, no habrá marcha atras"
    );
    if (agree) {
        if (fuerza)
            document.getElementById("formulario").action =
                "{{ route('informes.subirFuerza') }}";
        return true;
    } else return false;
}
