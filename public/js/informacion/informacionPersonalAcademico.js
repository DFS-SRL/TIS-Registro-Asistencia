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

// acordarse si algun colapsado esta activado o no
function remember()
{
    if (localStorage.getItem("collapseOne" + sis + dep) !== null) {
        $("#collapseOne").attr(
            "class",
            localStorage.getItem("collapseOne" + sis + dep)
        );
    }
    if (localStorage.getItem("collapseTwo" + sis + dep) !== null) {
        $("#collapseTwo").attr(
            "class",
            localStorage.getItem("collapseTwo" + sis + dep)
        );
    }
    if (localStorage.getItem("collapseThree" + sis + dep) !== null) {
        $("#collapseThree").attr(
            "class",
            localStorage.getItem("collapseThree" + sis + dep)
        );
    }
}

function accionColapsar(idAccionado, idOtro1, idOtro2 = "") {
    if (idOtro2 != "") {
        idOtro2 = "#" + idOtro2;
    }
    estado1 = $('#' + idOtro1).attr('class');
    estado2 = $(idOtro2).attr('class');
    if ($('#' + idAccionado).attr('class') == 'collapse') {
        $('#' + idAccionado).collapse('show');
        localStorage.setItem(idAccionado + sis + dep, "collapse show");
    } else {
        $('#' + idAccionado).collapse('hide');
        localStorage.setItem(idAccionado + sis + dep, "collapse");
    }
    $('#' + idOtro1).attr('class', estado1);
    $(idOtro2).attr('class', estado2);
}


function llenarTabla(asis) {
    var table;
    
    if(asis.length === 0)
        table = "<h4 class='textoBlanco'><b>No se tienen asistencias registradas.</b></h3>"
    else{
        table =
            `
        <table class="table table-responsive">
            <tr>
            <th class="textoBlanco border border-dark">MATERIA` + (docente ? "" : "/CARGO") + `</th>
            <th class="textoBlanco border border-dark">GRUPO` + (docente? "" : "/ÍTEM") + `</th>
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
                esMat = elem.materia.es_materia;
                link1 = window.location.host + "/" + (esMat ? "materia" : "cargo") + "/" + elem.materia.id;
                link2 = window.location.host + "/" + (esMat ? "grupo" : "item") + "/" + elem.grupo.id;
                table += "<tr>" +
                    `<td class = "border border-dark"> <a href="` + link1 + `">`+ elem.materia.nombre + "</a> </td>" +
                    `<td class = "border border-dark"> <a href="` + link2 + `">`+ elem.grupo.nombre + "</a> </td>" +
                    `<td class = "border border-dark">` + elem.fecha + "</td>" +
                    `<td class = "border border-dark">` + elem.horario_clase.hora_inicio + " - " + elem.horario_clase.hora_fin + "</td>" +
                    `<td class = "border border-dark">` + cambiarTexto(elem.actividad_realizada) + "</td>" +
                    `<td class = "border border-dark">` + cambiarTexto(elem.indicador_verificable) + "</td>" +
                    `<td class = "border border-dark">` + cambiarTexto(elem.observaciones) + "</td>" +
                    `<td class = "border border-dark">` + cambiarTexto(elem.asistencia) + "</td>" +
                    `<td class = "border border-dark">` + cambiarTexto(elem.permiso) + "</td>" +
                    "</tr>"
                    ;
            }
        );
    
        table += "</table>";
    }

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