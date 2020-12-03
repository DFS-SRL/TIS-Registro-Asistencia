/**
 * Habilita las opciones para editar la informacion de una asistencia
 */
var nombres = [
    "actividad",
    "indicador",
    "observaciones",
    "asistencia",
    "permiso"
];
function camposEdicionAsitencia(asistenciaId, asistencia, rolId) {
    // Vaciamos los elementos de la fila y añadimos las opciones
    nombres.forEach(nombre => {
        $("#" + nombre + asistenciaId)
            .children()
            .hide();
    });

    $("#actividad" + asistenciaId).append(
        `
        <textarea
            class="borrar actividad ` + asistenciaId + `"
            maxlength="150" id="actividadE` + asistenciaId + `"
            onkeypress="valLim(150, 'actividadE` + asistenciaId + `', 'msgAct` + asistenciaId + `');"
            onkeyup="valLim(150, 'actividadE` + asistenciaId + `', 'msgAct` + asistenciaId + `'); upAct(` + asistenciaId + `)"
        ></textarea>
        <label class ="borrar text-danger" id="msgAct` + asistenciaId + `" for="actividadE` + asistenciaId + `"></label>
        `
    );
    
    if (rolId != 1)
        $("#indicador" + asistenciaId).append(
            `
            <textarea
                class="borrar verificable ` + asistenciaId + `"
                id="verificableE` + asistenciaId + `"
                onkeyup="upVer(` + asistenciaId + `)"
            ></textarea>
            <label class ="borrar text-danger" id="msgVer` + asistenciaId + `" for="verificableE` + asistenciaId + `"></label>
            `
        );

    $("#observaciones" + asistenciaId).append(
        `
        <textarea
            class="borrar observacion ` + asistenciaId + `"
            maxlength="200" id="observacion` + asistenciaId + `"
            onkeypress="valLim(200, 'observacion` + asistenciaId + `', 'msgObs` + asistenciaId + `')"
            onkeyup="valLim(200, 'observacion` + asistenciaId + `', 'msgObs` + asistenciaId + `'); upObs(` + asistenciaId + `)"
        ></textarea>
        <label class ="borrar text-danger" id="msgObs` + asistenciaId + `" for="observacion` + asistenciaId + `"></label>
        `
    );
    
    $("#asistencia" + asistenciaId).append(
        `
        <div class="borrar custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="asistenciaE` + asistenciaId + `" onclick='habilitarDeshabilitar(` + asistenciaId + `); habilitarDeshabilitarE(` + asistenciaId + `)' autocomplete="off" checked/>
            <label class="custom-control-label" for="asistenciaE` + asistenciaId + `"></label>
        </div>
        `
    );

    $("#permiso" + asistenciaId).append(
        `
        <select value="" id="select` + asistenciaId + `" disabled class="borrar"
            onchange="combo(this.selectedIndex, ` + asistenciaId + `); comboE(` + asistenciaId + `); " onfocus="this.selectedIndex = -1;"
        >
            <option value="">Sin Permiso</option>
            <option value="LICENCIA">Licencia</option>
            <option value="BAJA_MEDICA">Baja medica</option>
            <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
        </select>
        <br>
        <input class="` + asistenciaId + ` mt-4 borrar" type="file" id="documento_adicional` + asistenciaId + `" disabled>
        `
    );

    $("#botonEditar" + asistenciaId).hide();
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
function cancelarEdicionAsistencia(asistenciaId) {
    nombres.forEach(nombre => {
        $("#" + nombre + asistenciaId)
            .children()
            .show();
    });
    $(".borrar").remove();
    $(".form" + asistenciaId).val('');

    $("#botonEditar" + asistenciaId).show();
    $("#botonAceptar" + asistenciaId).remove();
    $("#botonCancelar" + asistenciaId).remove();
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

function validarCamposUsuario(rolId) {
    res = false;
    if (rolId == 2) res = validarCampos();
    else res = valMinAct();
    return res;
}

function comboE(codigo) {
    document.getElementById(
        "permiso-form" + codigo
    ).value = document.getElementById("select" + codigo).value;
}

/* habilita y deshabilita los campos de editar asistencia dependiendo del switch del formulario*/
function habilitarDeshabilitarE(codigo) {
    elementos = document.getElementsByClassName(codigo);

    if (elementos[0].disabled)
        $(".fa" + codigo).val("");
    else 
        $(".fb" + codigo).val("");
}

function upAct(codigo)
{
    $("#actividad-form" + codigo).val($("#actividadE" + codigo).val());
}
function upVer(codigo) {
    $("#indicador-form" + codigo).val($("#verificableE" + codigo).val());
}
function upObs(codigo) {
    $("#observaciones-form" + codigo).val($("#observacion" + codigo).val());
}