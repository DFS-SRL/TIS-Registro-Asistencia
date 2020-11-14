/* Valida el limite de letras en el textarea especificado en sus parametros*/
function valLim(limite, textarea, msg) {
    let textAreaAct = document.getElementById(textarea);
    numCaracteres = textAreaAct.value.length;
    console.log(msg);
    if (numCaracteres >= limite) {
        document.getElementById(msg).innerHTML =
            "L&iacutemite de caracteres alcanzado";
    } else {
        document.getElementById(msg).innerHTML = "";
    }
}
/*Valida el limite de letras en actividadRealizada */
/* function valLimAct(codigo) {
    let textAreaAct = document.getElementById("actividad" + codigo);
    let limite = 150;
    numCaracteres = textAreaAct.value.length;
    if (numCaracteres >= limite) {
        document.getElementById("msgAct" + codigo).innerHTML =
            "L&iacutemite de caracteres alcanzado";
    } else {
        document.getElementById("msgAct" + codigo).innerHTML = "";
    }
} */
/*Valida el limite de caracteres en Observaciones*/
/* function valLimObs(codigo) {
    let textAreaAct = document.getElementById("observacion" + codigo);
    let limite = 200;
    numCaracteres = textAreaAct.value.length;
    if (numCaracteres >= limite) {
        document.getElementById("msgObs" + codigo).innerHTML =
            "L&iacutemite de caracteres alcanzado";
    } else {
        document.getElementById("msgObs" + codigo).innerHTML = "";
    }
} */

/*valida los campos actividad realizada e indicador verificable */
function validarCampos(){
    return valMinAct() && valIndVer();
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

/*valida que los auxiliares especifiquen obligatoriamente el campo indicador verificable */
function valIndVer(){
    let res = true;
    let verificables = document.getElementsByClassName('verificable');
    for(verificable of verificables){
        if(verificable.disabled){
           res = res && true; 
        }else{
            //console.log("entra aqui");
            if(verificable.value.length == 0){
                id = verificable.id.replace('verificable',"");
                document.getElementById("msgVer" + id).innerHTML = "es obligatorio especificar un indicador verificable"
                res = res && false;
            }else{
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

/*valida que el campo de busqueda de docentes o auxiliares para asignar a un grupo, no este vacio y que solo contenga numeros*/
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
// funcion para confirmacion de la desasignacion de auxiliar de un grupo/item
function confirmarDesasignarAuxiliar(auxiliar) {
    if (confirm("¿Estás seguro de desasignar al auxiliar " + auxiliar + "?"))
        document.getElementById("desasignar-auxiliar").submit();
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
