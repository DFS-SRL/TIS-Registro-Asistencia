function cambiarGrupos(actuales){
    if(actuales){
        $('#gruposActuales').show();
        $('#gruposAntiguos').hide();
    }else{
        $('#gruposAntiguos').show();
        $('#gruposActuales').hide();
    }
}

function expandir(idAccionado, idOtro){
    estado = $('#'+idOtro).attr('class')
    if($('#'+idAccionado).attr('class') == 'collapse'){
        $('#'+idAccionado).collapse('show');
    }else{
        $('#'+idAccionado).collapse('hide');
    }
    $('#'+idOtro).attr('class',estado)
}