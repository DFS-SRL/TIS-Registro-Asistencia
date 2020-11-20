function cambiarGrupos(actuales){
    if(actuales){
        $('#gruposActuales').show();
        $('#gruposAntiguos').hide();
    }else{
        $('#gruposAntiguos').show();
        $('#gruposActuales').hide();
    }
}
function cambiarItems(actuales){
    if(actuales){
        $('#itemsActuales').show();
        $('#itemsAntiguos').hide();
    }else{
        $('#itemsAntiguos').show();
        $('#itemsActuales').hide();
    }
}

$(window).on('load', function(){
    $('#inlineRadio1').prop("checked", true);
    $('#inlineRadio3').prop("checked", true);
});

function accionColapsar(idAccionado, idOtro1, idOtro2 = ""){
    if(idOtro2 != ""){
        idOtro2= "#"+idOtro2;
    }
    estado1 = $('#'+idOtro1).attr('class');
    estado2 = $(idOtro2).attr('class');
    if($('#'+idAccionado).attr('class') == 'collapse'){
        $('#'+idAccionado).collapse('show');
    }else{
        $('#'+idAccionado).collapse('hide');
    }
    $('#'+idOtro1).attr('class',estado1);
    $(idOtro2).attr('class',estado2);
}