function cambiarGrupos(actuales) {
    if (actuales) {
        $('#gruposActuales').show();
        $('#gruposAntiguos').hide();
    } else {
        $('#gruposAntiguos').show();
        $('#gruposActuales').hide();
    }
}
function cambiarItems(actuales) {
    if (actuales) {
        $('#itemsActuales').show();
        $('#itemsAntiguos').hide();
    } else {
        $('#itemsAntiguos').show();
        $('#itemsActuales').hide();
    }
}

$(window).on('load', function () {
    $('#inlineRadio1').prop("checked", true);
    $('#inlineRadio3').prop("checked", true);
});

function accionColapsar(idAccionado, idOtro1, idOtro2 = "") {
    if (idOtro2 != "") {
        idOtro2 = "#" + idOtro2;
    }
    estado1 = $('#' + idOtro1).attr('class');
    estado2 = $(idOtro2).attr('class');
    if ($('#' + idAccionado).attr('class') == 'collapse') {
        $('#' + idAccionado).collapse('show');
    } else {
        $('#' + idAccionado).collapse('hide');
    }
    $('#' + idOtro1).attr('class', estado1);
    $(idOtro2).attr('class', estado2);
}


function llenarTabla(asis) {
    var table =
        `
    <table class="table table-bordered table-responsive">
        <tr>
        <th class="textoBlanco border border-dark">MATERIA/CARGO</th>
        <th class="textoBlanco border border-dark">GRUPO/ÍTEM</th>
        <th class="textoBlanco border border-dark">FECHA</th>
        <th class="textoBlanco border border-dark">HORARIO</th>
        <th class="textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
        <th class="textoBlanco border border-dark">INDICADOR VERIFICABLE</th>
        <th class="textoBlanco border border-dark">OBSERVACIONES</th>
        <th class="textoBlanco border border-dark">ASISTENCIA</th>
        <th class="textoBlanco border border-dark">PERSMISO</th>
        </tr>
    `;

    asis.forEach(
        function callback(elem, index, array) {
            table += "<tr>" +
                "<td>" + elem.materia.nombre + "</td>" +
                "<td>" + elem.grupo.nombre + "</td>" +
                "<td>" + elem.fecha + "</td>" +
                "<td>" + elem.horario_clase.hora_inicio + " - " + elem.horario_clase.hora_fin + "</td>" +
                "<td>" + cambiarTexto(elem.actividad_realizada) + "</td>" +
                "<td>" + cambiarTexto(elem.indicador_verificable) + "</td>" +
                "<td>" + cambiarTexto(elem.observaciones) + "</td>" +
                "<td>" + cambiarTexto(elem.asistencia) + "</td>" +
                "<td>" + cambiarTexto(elem.permiso) + "</td>" +
                "</tr>"
                ;
        }
    );

    table += "</table>";

    var div = $('#asistencias-content').html(table);
}

function cambiarTexto(txt) {
    if (txt === null)
        return "-";
    if (txt === true)
        return "SI";
    if (txt === false)
        return "NO";
    if (txt.includes("_"))
        return txt.replaceAll("_", " ");
    return txt;
}