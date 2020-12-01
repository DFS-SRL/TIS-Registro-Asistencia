/**
 * Habilita las opciones para editar la informacion de una asistencia
 */
function camposEdicionAsitencia(asistenciaId, asistencia) {
    // var esMateria = true;
    // if (horario["rol_id"] == 1) esMateria = false;

    // Vaciamos los elementos de la fila y añadimos las opciones
    // $("#horario" + horarioId + ", #dia" + horarioId)
    //     .children("p")
    //     .hide();

    // if (esMateria) {
    //     $("#horario" + horarioId).append(
    //         '<select id="dias' + horarioId + '"></select>'
    //     );
    // } else {
    //     $("#dia" + horarioId).append(
    //         '<select id="dias' + horarioId + '"></select>'
    //     );
    // }
    // var dias = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
    // dias.forEach(dia => {
    //     $("#dias" + horarioId).append(
    //         '<option value="' + dia + '">' + dia + "</option>"
    //     );
    //     if (dia == horario["dia"]) {
    //         $("#dias" + horarioId + " :last-child").prop(
    //             "selected",
    //             "selected"
    //         );
    //     }
    // });

    // $("#horario" + horarioId).append(
    //     '<input class="ml-1" type="time" id="horaInicio' +
    //         horarioId +
    //         '" value="' +
    //         horario["hora_inicio"].substring(0, 5) +
    //         '" onchange="setHoraFin(' +
    //         horarioId +
    //         ", " +
    //         esMateria +
    //         ')"></input>'
    // );
    // $("#horario" + horarioId).append(
    //     '<input class="ml-1" type="time" id="horaFin' +
    //         horarioId +
    //         '" value="' +
    //         horario["hora_fin"].substring(0, 5) +
    //         '" disabled></input>'
    // );

    // Obtenemos la diferencia entre la hora de inicio y la hora fin
    // y asignamos esa diferencia a los periodos
    // var splitTimeInicio = horario["hora_inicio"].split(":");
    // var horaInicio = parseInt(splitTimeInicio[0]);
    // var minutosInicio = parseInt(splitTimeInicio[1]);

    // var splitTimeFin = horario["hora_fin"].split(":");
    // var horaFin = parseInt(splitTimeFin[0]);
    // var minutosFin = parseInt(splitTimeFin[1]);

    // var periodos = horaFin * 60 + minutosFin - horaInicio * 60 - minutosInicio;
    // if (esMateria) periodos /= 45;
    // else periodos /= 60;

    // $("#horario" + horarioId).append(
    //     '<input class="ml-1" type="number" name="" id="periodo' +
    //         horarioId +
    //         '" min="1" max="12" value="' +
    //         periodos +
    //         '" onchange="setHoraFin(' +
    //         horarioId +
    //         ", " +
    //         esMateria +
    //         ')">'
    // );

    // $("#cargo" + horarioId)
    //     .children("p")
    //     .hide();
    // $("#cargo" + horarioId).append(
    //     '<select id="cargos' + horarioId + '"></select>'
    // );
    // $("#cargos" + horarioId).append(
    //     '<option value="DOCENCIA">DOCENCIA</option>'
    // );
    // $("#cargos" + horarioId).append(
    //     '<option value="AUXILIATURA">AUXILIATURA</option>'
    // );
    // if (horario["rol_id"] == 3)
    //     $("#cargos" + horarioId + " :first-child").prop("selected", "selected");
    // else $("#cargos" + horarioId + " :last-child").prop("selected", "selected");

    // $("#botonEditar" + horarioId).hide();
    // $("[id^=botonEditar]").prop("disabled", true);
    // $("[id^=botonEliminar]").prop("disabled", true);
    // $("#botonEliminar" + horarioId).prop("disabled", false);

    $("#botonEditar" + asistenciaId).hide();
    $("[id^=botonEditar]").prop("disabled", true);
    $("#botonEliminar" + asistenciaId).prop("disabled", false);

    $(
        "<input id = botonAceptar" +
            asistenciaId +
            ' width="30rem" height="30rem" type="image" name="botonAceptar"' +
            ' src="/icons/aceptar.png" alt="Aceptar"onclick="aceptarEdicionAsistencia(' +
            asistenciaId +
            ')">'
    ).insertBefore("#botonEditar" + asistenciaId);

    $(
        "<input id = botonCancelar" +
            asistenciaId +
            ' width="30rem" height="30rem" type="image" name="botonCancelar"' +
            ' src="/icons/cancelar.png" alt="Cancelar"onclick="cancelarEdicionAsistencia(' +
            asistenciaId +
            '); activar()">'
    ).insertBefore("#botonEditar" + asistenciaId);
}

/**
 * Cancela la edicion de un horario
 */
function cancelarEdicionAsistencia(horarioId) {
    // Eliminamos los elemtnos para editar horario y mostramos los que tienen informacion
    // $("#horario" + horarioId)
    //     .children("p")
    //     .show();
    // $("#dia" + horarioId)
    //     .children("p")
    //     .show();
    // $("#horario" + horarioId + " :not(:first-child)").remove();
    // $("#dia" + horarioId + " :not(:first-child)").remove();

    // $("#cargo" + horarioId)
    //     .children("p")
    //     .show();
    // $("#cargo" + horarioId + " :not(:first-child)").remove();

    $("#botonEditar" + horarioId).show();
    $("[id^=botonEditar]").prop("disabled", false);
    $("#botonAceptar" + horarioId).remove();
    $("#botonCancelar" + horarioId).remove();
}

/**
 * Aceptar la edicion del horario enviando el form
 */
function aceptarEdicionAsistencia(horarioId) {
    // Llenamos el form de actualizacion con los datos ingresados
    // $("#horaInicioForm" + horarioId).val($("#horaInicio" + horarioId).val());
    // $("#horaFinForm" + horarioId).val($("#horaFin" + horarioId).val());
    // $("#diaForm" + horarioId).val(
    //     $("#dias" + horarioId + " option:selected").text()
    // );
    // var rol;
    // if ($("#cargos" + horarioId + " option:selected").text() == "AUXILIATURA") {
    //     rol = 2;
    // } else {
    //     rol = 3;
    // }
    // if (!$("#cargos" + horarioId).length) {
    //     rol = 1;
    // }
    // $("#rolIdForm" + horarioId).val(rol);

    // document.getElementById("editar-horario" + horarioId).submit();
    window.alert("despedidoooo");
}
