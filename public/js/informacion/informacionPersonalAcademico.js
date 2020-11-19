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