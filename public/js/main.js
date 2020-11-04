const { functionsIn } = require("lodash");

/*Valida el limite de letras en actividadRealizada */
function valLimAct(codigo){
    let textAreaAct = document.getElementById("actividad"+codigo);
    let limite = 150;
    numCaracteres = textAreaAct.value.length;
    if(numCaracteres >= limite){
        document.getElementById("msgAct"+codigo).innerHTML = "L&iacutemite de caracteres alcanzado";
    }else{
        document.getElementById("msgAct"+codigo).innerHTML = "";
    }
}
/*Valida el limite de caracteres en Observaciones*/
function valLimObs(codigo){
    let textAreaAct = document.getElementById("observacion"+codigo);
    let limite = 200;
    numCaracteres = textAreaAct.value.length;
    if(numCaracteres >= limite){
        document.getElementById("msgObs"+codigo).innerHTML = "L&iacutemite de caracteres alcanzado";
    }else{
        document.getElementById("msgObs"+codigo).innerHTML = "";
    }
}
/*Valida numero minimo de caracteres para actividad realizada */
function valMinAct(){
    let res = true;
    let actividades = document.getElementsByClassName("actividad");
    for(actividad of actividades){
        if(actividad.disabled){
            res = res && true;
        }
        else{
            if(actividad.value.length < 5){
                console.log("Llenar campo actividad");
                id = actividad.id.replace('actividad','');
                document.getElementById("msgAct"+id).innerHTML = "N&uacutemero de caracteres insuficiente";
                console.log(id);
                res = res && false;

            }else{
                console.log("Llenado correctamente");
                res = res && true;
            }
        }
    }
    return res;
}

/* habilita y deshabilita los textarea y el combobox de la planilla semanal de docente dependiendo del switch del formulario*/

function habilitarDeshabilitar(codigo){
    elementos = document.getElementsByClassName(codigo);
    select = document.getElementById("select"+codigo);
    
    if(elementos[0].disabled){
        for(elemento of elementos){
            elemento.removeAttribute("disabled");
            select.setAttribute("disabled", "");
        }
        document.getElementById("asistenciaFalse"+codigo).value= true;
    }else{
        for(elemento of elementos){
            elemento.setAttribute("disabled", "");
            elemento.value = "";
            select.removeAttribute("disabled");
        }
        document.getElementById("msgAct"+codigo).innerHTML = "";
        document.getElementById("msgObs"+codigo).innerHTML = "";
        document.getElementById("asistenciaFalse"+codigo).value= false;
    }
}
/*deshabilita el boton de horarios si existen horarios */
function habilitarBotonRegistrar(horarios){
    console.log(horarios);
    if(horarios > 0 ){
        document.getElementById("registrar").style.display = "block";
        console.log("es vacio");
    }
}
/*al hacer click en boton editar de grupo materia se redirige a la vista editar */

/*habilita el campo de busqueda al precionar el boton "asignar ..." en la vista de edicion de informacion de un grupo*/
function botonAsignar(botonId, botonBuscadorId, buscadorId){
    $('#'+botonId).hide() ;
    $('#'+botonBuscadorId).show();
    $('#'+buscadorId).addClass("form-control");
}

/*valida que el campo de busqueda de docentes o auxiliares   para asignar a un grupo, no este vacio y que solo contenga numeros*/
function validarBusquedaAsignar(buscadorId, msgObsId){
    campoBusqueda = document.getElementById(buscadorId);
    let res;
    if(campoBusqueda.value.length == 0){
        document.getElementById(msgObsId).innerHTML = "debe especificar el codSis del docente que desea asignar a este grupo";
        res = false;
    }else if(!contieneSoloNumeros(campoBusqueda.value)){
        document.getElementById(msgObsId).innerHTML = "solo se permiten caracteres numéricos";
        res = false;
    }else{
        res = true;
    }
    return res;
}

function contieneSoloNumeros(texto){
    let res = true;
    for(pos = 0; pos < texto.length && res; pos++){
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
 * Los valores por defecto no son los del horario a ser cambiado
 */
function camposEdicionHorarioDeGrupo(horarioId) {
    
    // Vaciamos los elementos de la fila y añadimos las opciones
    $("#horario"+horarioId).empty();
    $("#horario"+horarioId).append("<select id=\"dias"+horarioId+"\"></select>");
    var dias = ["LUNES", "MARTES", "MIERCOLES", "JUEVES", "VIERNES", "SABADO"];
    dias.forEach(dia => {
        $("#dias"+horarioId).append("<option value=\""+dia+"\">"+dia+"</option>");
    });

    $("#horario"+horarioId).append("<input class=\"ml-1\" type=\"time\" id=\"horaInicio"+horarioId+"\"></input>");
    $("#horario"+horarioId).append("<input class=\"ml-1\" type=\"time\" id=\"horaFinal"+horarioId+"\"></input>");

    $("#cargo"+horarioId).empty();
    $("#cargo"+horarioId).append("<select id=\"cargos"+horarioId+"\"></select>");
    $("#cargos"+horarioId).append("<option value=\"DOCENCIA\">DOCENCIA</option>");
    $("#cargos"+horarioId).append("<option value=\"AUXILIATURA\">AUXILIATURA</option>");

    $('#botonEditar'+horarioId).hide();
    
    $("<input id = botonAceptar"+horarioId+" width=\"30rem\" height=\"30rem\" type=\"image\" name=\"botonAceptar\" src=\"/icons/aceptar.png\" alt=\"Aceptar\"onclick=\"alert('aceptar! :D')\">").insertBefore("#botonEliminar"+horarioId);
    
    $("<input id = botonCancelar"+horarioId+" width=\"30rem\" height=\"30rem\" type=\"image\" name=\"botonCancelar\" src=\"/icons/cancelar.png\" alt=\"Cancelar\"onclick=\"cancelarEdicionHorarioDeGrupo("+horarioId+")\">").insertBefore("#botonEliminar"+horarioId);
}

/**
 * Cancela la edicion de un horario recargando la pagina
 */
function cancelarEdicionHorarioDeGrupo(horarioId) {
    location.reload();
}

/**
 * Aplicar la actualizacion del horario
 */
function aceptarEdicionHorarioDeGrupo(horarioId) {
    
}