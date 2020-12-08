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
    // console.log(asis);
    if(asis.length === 0)
        table = "<h4 class='textoBlanco'><b>No se tienen asistencias registradas.</b></h3>"
    else{
        table =
            `
        <table class="table table-responsive" id="asistencias">
            <tr>
            <th class="textoBlanco border border-dark">MATERIA` + (docente ? "" : "/CARGO") + `</th>
            <th class="textoBlanco border border-dark">GRUPO` + (docente? "" : "/ÍTEM") + `</th>
            <th class="textoBlanco border border-dark">FECHA</th>
            <th class="textoBlanco border border-dark" >HORARIO</th>
            <th class="textoBlanco border border-dark">ACTIVIDAD REALIZADA</th>
            <th class="textoBlanco border border-dark">INDICADOR VERIFICABLE</th>
            <th class="textoBlanco border border-dark ">OBSERVACIONES</th>
            <th class="textoBlanco border border-dark">ASISTENCIA</th>
            <th class="textoBlanco border border-dark">PERSMISO</th>
            <th class="textoBlanco border border-dark" style="text-align:center;">OPCIONES</th>
            </tr>
        `;
        asis.forEach(
            function callback(elem, index, array) {
                esMat = elem.materia.es_materia;
                link1 = window.location.host + "/" + (esMat ? "materia" : "cargo") + "/" + elem.materia.id;
                link2 = window.location.host + "/" + (esMat ? "grupo" : "item") + "/" + elem.grupo.id;
                descargarDocumento = "";
                botonDescarga = "";
                if (elem.documento_adicional != null) {
                    descargarDocumento = "descargarDoc('"+elem.documento_adicional+"')";
                    // console.log('documento de ' + elem.id + ': ' + elem.documento_adicional);
                    botonDescarga = `<button type="button" class="btn btn-success boton" onclick="`+descargarDocumento+`" >
                                <svg width="3em" height="3em" viewBox="0 0 16 16" class="bi bi-file-earmark-text" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                    <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                            </button>`
                }
                table += "<tr id="+elem.id+">" +
                    `<td class = "border border-dark"> <a href="` + link1 + `">`+ elem.materia.nombre + "</a> </td>" +
                    `<td class = "border border-dark"> <a href="` + link2 + `">`+ elem.grupo.nombre + "</a> </td>" +
                    `<td class = "border border-dark"><p>` + elem.fecha + "</p></td>" +
                    `<td class = "border border-dark"><p>` + elem.horario_clase.hora_inicio + " - " + elem.horario_clase.hora_fin + "</p></td>" +
                    `<td id=actividad`+elem.id+` class = "border border-dark" style="text-align:justify"><p >` + cambiarTexto(elem.actividad_realizada) + "</p></td>" +
                    `<td id=indicador`+elem.id+` class = "border border-dark"><p>` + cambiarTexto(elem.indicador_verificable) + "</p></td>" +
                    `<td id=observaciones`+elem.id+` class = "border border-dark"><p>` + cambiarTexto(elem.observaciones) + "</p></td>" +
                    `<td id=asistencia`+elem.id+` class = "border border-dark"><p>` + cambiarTexto(elem.asistencia) + "</p></td>" +
                    `<td id=permiso`+elem.id+` class = "border border-dark"><p>` + 
                        botonDescarga + 
                        '<div id="miPermiso' + elem.id + '">' + cambiarTexto(elem.permiso) + "</div></p></td>" +
                    `<td id=opciones`+elem.id+` class = "border border-dark " style="width:180px;vertical-align:middle;">
                        <input type='image' 
                            width="30rem"
                            height="30rem"
                            id="botonEditar`+elem.id+`"`
                            + (elem.nivel == 2 ?
                                `onclick="camposEdicionAsitencia(`+elem.id+','+elem.horario_clase.rol_id+`);desactivar();"
                                src='/icons/editar.png'`
                            : `src='/icons/editarDis.png' disabled` )
                            +
                            `> 
                            `
                            +
                            (elem.nivel == 2 ? `<form method="POST" action="` + miHost + '/asistencia/' + elem.id + '/permiso' + `"  style="display: inline;">
                            ` + csrf + `
                                <input type="hidden" name="_method" value="PATCH">
                                <button id="permisoEdicion`+elem.id+`" class="btn boton float-right" style="font-size:0.7em;">PERMISO EDICION</button>
                            </form>`
                            : `<button id="permisoEdicion`+elem.id+`" class="btn boton float-right" style="font-size:0.7em;" disabled >PERMISO EDICION</button>` ) 
                            +
                    `</tr>`
                    ;
            }
        );
    
        table += "</table>";
    }

    var div = $('#asistencias-content').html(table);
}



function cambiarTexto(txt) {
    if (txt === null)
        return "";
    if (txt === true)
        return "SI";
    if (txt === false)
        return "NO";
    if (txt.includes("_"))
        return txt.replaceAll("_", " ");
    return txt;
}

// descarga un documento adicional segun su nombre
function descargarDoc(nombre) {
    window.location.href = '/archivo/descargar/'+nombre;
}