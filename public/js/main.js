
function habilitarDeshabilitar(obj){
    codigo = obj.id.substr(obj.id.length-2, 2);
    elementos = document.getElementsByClassName(codigo);
    select = document.getElementById("select"+codigo);
    if(elementos[0].disabled){
        for(elemento of elementos){
            elemento.removeAttribute("disabled");
            select.setAttribute("disabled", "");
        }
    }else{
        for(elemento of elementos){
            elemento.setAttribute("disabled", "");
            select.removeAttribute("disabled");
        }
    }
}

function enviarPlanillas(){
    let botonesEnviar = document.getElementsByClassName('enviar');
    for (let boton of botonesEnviar) {
        boton.click();
    }
}