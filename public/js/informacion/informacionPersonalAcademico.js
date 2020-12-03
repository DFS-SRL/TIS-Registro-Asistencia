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
    console.log(asis);
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
            <th class="textoBlanco border border-dark" style="text-align:center;">OPCIONES</th>
            </tr>
        `;
    
        asis.forEach(
            function callback(elem, index, array) {
                esMat = elem.materia.es_materia;
                link1 = window.location.host + "/" + (esMat ? "materia" : "cargo") + "/" + elem.materia.id;
                link2 = window.location.host + "/" + (esMat ? "grupo" : "item") + "/" + elem.grupo.id;
                table += "<tr id="+elem.id+">" +
                    `<td class = "border border-dark"> <a href="` + link1 + `">`+ elem.materia.nombre + "</a> </td>" +
                    `<td class = "border border-dark"> <a href="` + link2 + `">`+ elem.grupo.nombre + "</a> </td>" +
                    `<td class = "border border-dark">` + elem.fecha + "</td>" +
                    `<td class = "border border-dark">` + elem.horario_clase.hora_inicio + " - " + elem.horario_clase.hora_fin + "</td>" +
                    `<td id=actividad`+elem.id+` class = "border border-dark">` + cambiarTexto(elem.actividad_realizada) + "</td>" +
                    `<td id=indicador`+elem.id+` class = "border border-dark">` + cambiarTexto(elem.indicador_verificable) + "</td>" +
                    `<td id=observaciones`+elem.id+` class = "border border-dark">` + cambiarTexto(elem.observaciones) + "</td>" +
                    `<td id=asistencia`+elem.id+` class = "border border-dark">` + cambiarTexto(elem.asistencia) + "</td>" +
                    `<td id=permiso`+elem.id+` class = "border border-dark">` + cambiarTexto(elem.permiso) + "</td>" +
                    `<td class = "border border-dark " style="width:180px;vertical-align:middle;">
                        <input type='image' 
                                src='/icons/editar.png'
                                width="30rem"
                                height="30rem"
                                onclick="editarAsistencia(`+elem.id+`)">
                        <input type="button" class="btn boton float-right" style="font-size:0.7em;"value="PERMISO EDICION">
                    </td>`+
                    "</tr>"
                    ;
            }
        );
    
        table += "</table>";
    }

    var div = $('#asistencias-content').html(table);
}

function editarAsistencia(idFila){
    let actividad = document.getElementById("actividad"+idFila);
    let indicador = document.getElementById("indicador"+idFila);
    let observaciones = document.getElementById("observaciones"+idFila);
    let asistencia = document.getElementById("asistencia"+idFila);
    let permiso = document.getElementById("permiso"+idFila);
    actividad.innerHTML =  `<textarea maxlength='150' style="width:8rem;">`+actividad.firstChild.nodeValue+`</textarea>                             
                            <label class ="text-danger" id="msgAct+ID" for="idTA"></label>`;
    indicador.innerHTML =  `<textarea style="width:8rem;"></textarea>
                            <label class ="text-danger" id="msgVer+ID" for="idTA"></label>`;
    observaciones.innerHTML =  `<textarea maxlength="200" style="width:8rem;">`+observaciones.firstChild.nodeValue+`</textarea>
                                <label class ="text-danger" id="msgObs+ID" for="idTA"></label>`;                    
    asistencia.innerHTML = `<div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input"  onclick='habilitarDeshabilitar()' autocomplete="off"/>
                                <label class="custom-control-label" for="asistencia"></label>
                            </div>`;
    permiso.innerHTML =`<select style="width:6.8rem;" 
                            onfocus="this.selectedIndex = -1;">
                            
                            <option value="">Sin Permiso</option>
                            <option value="LICENCIA">Licencia</option>
                            <option value="BAJA_MEDICA">Baja medica</option>
                            <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
                        </select>
                        <br>
                        <button class="btn boton float-right" style="padding:0px 4px 2px 6px">
                        <svg width="1.1em" height="1.1em" viewBox="0 0 18 18" class="bi bi-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                            <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                        </svg>
                        </button >
                        <input type="file"  hidden>`;                            
    // console.log(fila.appendChild);
    `<td class="border border-dark">

    </td>
<td class="border border-dark">
    </td>
<td class="border border-dark">
    <textarea name="asistencias[{{ $key1.$key2 }}][observaciones]" class = "{{$key1}}{{$key2}} observacion"  id="observacion{{$key1.$key2 }}" onkeypress="valLim(200, 'observacion{{$key1.$key2}}', 'msgObs{{$key1.$key2}}')" onkeyup="valLim(200, 'observacion{{$key1.$key2}}', 'msgObs{{$key1.$key2}}')" ></textarea>                            
    <label class ="text-danger" id="msgObs{{$key1.$key2 }}" for="observaciones"></label>
    </td>
<td class="border border-dark">
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="asistencia{{$key1}}{{$key2}}" onclick='habilitarDeshabilitar({{$key1.$key2}})' autocomplete="off" checked/>
        <label class="custom-control-label" for="asistencia{{$key1}}{{$key2}}"></label>
    </div>
</td>
<td class="border border-dark">
    <select 
        disabled
        onfocus="this.selectedIndex = -1;">

        <option value="">Sin Permiso</option>
        <option value="LICENCIA">Licencia</option>
        <option value="BAJA_MEDICA">Baja medica</option>
        <option value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
    </select>
    <br>
    <input type="file" disabled>
</td>`
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