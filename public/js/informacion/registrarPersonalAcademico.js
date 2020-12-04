//desmarca el check de docente si es que se marco algun check de auxiliar, y viceversa
function verificarCheckBoxes(id){
    if(id == "docente"){
        if($('#docente').prop('checked')){
            $('#auxDocencia').prop('checked',false);
            $('#auxLaboratorio').prop('checked',false);
        }
    }else{
        if($('#'+id).prop('checked')){
            $('#docente').prop('checked',false);
        }
    }
}
//valida que el campo de texto solo tenga numeros
function validarSoloNumeros(idInput,mensaje){
    input = document.getElementById(idInput).value;
    res = true;
    for(pos = 0; pos < input.length && res; pos++){
        res = input.charCodeAt(pos) >= 48 && input.charCodeAt(pos) <= 57;
    }
    if(!res){
        $('#'+mensaje).text('solo se admiten caracteres numericos');
    }
    return res;
}
// valida que un campo de texto no este vacio
function validarNoVacio(idCampoTexto){
    let texto = document.getElementById(idCampoTexto).value.trim();
    return texto.length != 0;
}

function validarCamposNoVacios(idFormulario){
    nombres = document.getElementById('nombres').value.trim();
    paterno = document.getElementById('paterno').value.trim();
    materno = document.getElementById('materno').value.trim();
    correo = document.getElementById('correo').value.trim();
    res = nombres.length != 0 && paterno != 0 && materno != 0 && correo.length != 0;
    if(!res){
        $('#mensajeFormulario').text('Se debe llenar todos los campos del formulario');
    }
    return res;
}