/**
 * Habilita las opciones para editar la informacion de una asistencia
 */
var nombres = [
    "actividad",
    "indicador",
    "observaciones",
    "asistencia",
    "permiso",
    "opciones"
];
function camposEdicionAsitencia(asistenciaId, rolId) {
    // Vaciamos los elementos de la fila y añadimos las opciones
    // console.log("as");
    nombres.forEach(nombre => {
        $("#" + nombre + asistenciaId)
        .children()
        .hide();
        // console.log("#" + nombre + asistenciaId);
    }); 

    $("#actividad" + asistenciaId).append(
        `
        <textarea
            class="borrar actividad ` + asistenciaId + `"
            maxlength="150" id="actividadE` + asistenciaId + `"
            onkeypress="valLim(150, 'actividadE` + asistenciaId + `', 'msgAct` + asistenciaId + `');"
            onkeyup="valLim(150, 'actividadE` + asistenciaId + `', 'msgAct` + asistenciaId + `'); upAct(` + asistenciaId + `)"
        >`+$("#actividad" + asistenciaId).first()[0].firstElementChild.innerHTML+`</textarea>
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
            >`+$("#indicador" + asistenciaId).first()[0].firstElementChild.innerHTML+`</textarea>
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
        >`+$("#observaciones" + asistenciaId).first()[0].firstElementChild.innerHTML+`</textarea>
        <label class ="borrar text-danger" id="msgObs` + asistenciaId + `" for="observacion` + asistenciaId + `"></label>
        `
    );
    
    $("#asistencia" + asistenciaId).append(
        `
        <div class="borrar custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="asistenciaE` + asistenciaId + `" onclick='habilitarDeshabilitar(` + asistenciaId + `); habilitarDeshabilitarE(` + asistenciaId + `)' autocomplete="off" `+setValueSwitchAsistencia(asistenciaId)+` />
            <label class="custom-control-label" for="asistenciaE` + asistenciaId + `"></label>
        </div>
        `
    );
    
    per = document.getElementById("miPermiso" + asistenciaId).innerHTML;
    console.log("|" + per + "|");
    console.log(per === 'BAJA MEDICA' ? 'selected' : '');
    $("#permiso" + asistenciaId).append(
        `
        <div class="input-group form-group">
            <select value="" disabled id="select` + asistenciaId + `" class="borrar"
                onchange="combo(this.selectedIndex, ` + asistenciaId + `); comboE(` + asistenciaId + `); " onfocus="this.selectedIndex = -1;"
            >
                <option value="">Sin Permiso</option>
                <option ` + (per === `LICENCIA` ? `selected` : ``) + `  value="LICENCIA">Licencia</option>
                <option ` + (per === `BAJA MEDICA` ? `selected` : ``) + ` value="BAJA_MEDICA">Baja medica</option>
                <option ` + (per === `DECLARATORIA EN COMISION` ? `selected` : ``) + `  value="DECLARATORIA_EN_COMISION">Declaratoria en comision</option>
            </select>
        </div>
        <div class="input-group form-group">
            <button class="` + asistenciaId + ` borrar btn btn block boton justify-content-center" id="documento_adicional`+asistenciaId+`"  style="font-size:0.7em;" >COMPROBANTE  <svg width="1.1em" height="1.1em" viewBox="0 0 18 18" class="bi bi-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg" >
            <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
            <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
            </svg>
            </button >
            <label class="` + asistenciaId + ` borrar" id="nombre_archivo` + asistenciaId + `"  for="documento_adicional` + asistenciaId + `"></label>
        </div>`
    );
    obsis = $("#observaciones" + asistenciaId).first()[0].firstElementChild.innerHTML;
    $("#opciones" + asistenciaId).append(
      `<form id="editar-asistencia`+asistenciaId+`" method="POST"
            action="/asistencia/`+asistenciaId+`" 
            onsubmit="return validarCamposUsuario(`+rolId+`)"
            enctype="multipart/form-data"
            style="display:none"
        >
            <input type="hidden" name="_token" value=`+$('meta[name ="csrf-token"]').attr('content')+`> 
            <input type="hidden" name="_method" value="PATCH">
            <input 
                id="actividad-form`+asistenciaId+`" 
                type="text" name="actividad_realizada"
                class="form`+asistenciaId+` fa`+asistenciaId+`"
                value="`+$("#actividad" + asistenciaId).first()[0].firstElementChild.innerHTML+`"
            >
            <input 
                id="indicador-form`+asistenciaId+`" 
                type="text" name="indicador_verificable"
                class="form`+asistenciaId+` fa`+asistenciaId+`"
                value="`+$("#indicador" + asistenciaId).first()[0].firstElementChild.innerHTML+`"
            >
            <input 
                id="observaciones-form`+asistenciaId+`" 
                type="text" name="observaciones"
                class="form`+asistenciaId+` fa`+asistenciaId+`"
                value="`+obsis+`"
            >
            <input 
                id="asistenciaFalse`+asistenciaId+`" 
                type="text" name="asistencia"
                class="form`+asistenciaId+`"
                value="`+document.getElementById("asistenciaE" + asistenciaId).checked+`"
            >
            <input 
                id="permiso-form`+asistenciaId+`"
                type="text" name="permiso"
                value="` + per.replace(" ", "_") + `"
                class="form`+asistenciaId+` fb`+asistenciaId+`"
            >
            <input 
                id="documento-form`+asistenciaId+`"
                type="file" name="documento_adicional"
                class="form`+asistenciaId+` fb`+asistenciaId+`"
                onchange="setLabelFile(`+asistenciaId+`)"
            >
            <button id=enviarCambios`+asistenciaId+`>Enviar</button>
        </form>`
    )
    $("#botonEditar" + asistenciaId).hide();
    $("#botonEliminar" + asistenciaId).prop("disabled", false);
    $("#permisoEdicion" + asistenciaId).hide();
    $(
        "<input id = botonAceptar" +
            asistenciaId +
            ' width="30rem" height="30rem" type="image" name="botonAceptar"' +
            ' src="/icons/aceptar.png" alt="Aceptar">'
    ).insertBefore("#botonEditar" + asistenciaId);

    $(
        "<input id = botonCancelar" +
            asistenciaId +
            ' width="30rem" height="30rem" type="image" name="botonCancelar"' +
            ' src="/icons/cancelar.png" alt="Cancelar"onclick="cancelarEdicionAsistencia(' +
            asistenciaId +
            '); activar()">'
    ).insertBefore("#botonEditar" + asistenciaId);

    document.getElementById('documento_adicional'+asistenciaId).addEventListener('click', () => {
        // document.getElementById("documento-form" + asistenciaId).disabled = false;
        document.getElementById("documento-form" + asistenciaId).click()
    })
    document.getElementById('botonAceptar'+asistenciaId).addEventListener('click', () => {
        // document.getElementById("documento-form" + asistenciaId).disabled = false;
        document.getElementById("enviarCambios" + asistenciaId).click()
    })
    setValueAsistencia(asistenciaId);
    if($("#asistencia" + asistenciaId).first()[0].firstElementChild.innerHTML === "NO")
    {
        combo(per === "" ? 0 : per == "LICENCIA" ? 1 : per == "BAJA MEDICA" ? 2 : 3,asistenciaId);
        $("#observacion" + asistenciaId).val(obsis)
    }
}

// function buttonEnabled(asistenciaId){
//     valueSwitch = document.getElementById("asistenciaE"+asistenciaId );
//     if(valueSwitch.checked){
//         return "disabled"
//     }else{
//         return "enabled";
//     }
// }

function setLabelFile(asistenciaId){
    file = document.getElementById("documento-form"+asistenciaId).value.split('\\')[2]
    document.getElementById("nombre_archivo"+asistenciaId).innerText=file;
}

function setValueSwitchAsistencia(asistenciaId){
    asistio = $("#asistencia" + asistenciaId).first()[0].firstElementChild.innerHTML;
    if(asistio === "SI")
        return "checked";
    return "unchecked";
}

function setValueAsistencia(asistenciaId){
    asistio = $("#asistencia" + asistenciaId).first()[0].firstElementChild.innerHTML;
    if(asistio == "NO"){
        habilitarDeshabilitar(asistenciaId);
    }else{
        documento = document.getElementById("documento_adicional"+asistenciaId);
        documento.setAttribute("disabled", "");
    }
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
    $("#editar-asistencia" + asistenciaId).remove();
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

function documentoE(codigo) {
    // console.log(document.getElementById("documento_adicional" + codigo));
    document.getElementById(
        "documento-form" + codigo
    ).value = document.getElementById("documento_adicional" + codigo).value;
}

/* habilita y deshabilita los campos de editar asistencia dependiendo del switch del formulario*/
function habilitarDeshabilitarE(codigo) {
    elementos = document.getElementsByClassName(codigo);
    // console.log(elementos);
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