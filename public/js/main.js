
/* habilita y deshabilita los textarea y el combobox de la planilla semanal de docente dependiendo del switch del formulario*/
function habilitarDeshabilitar(obj){
    codigo = obj.id.substr(obj.id.length-2, 2);
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
            select.removeAttribute("disabled");
        }
        document.getElementById("asistenciaFalse"+codigo).value= false;
    }
}