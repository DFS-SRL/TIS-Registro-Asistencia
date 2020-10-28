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
/* */