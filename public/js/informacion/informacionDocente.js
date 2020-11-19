function cambiarGrupos(actuales){
    if(actuales){
        $('#gruposActuales').show();
        $('#gruposAntiguos').hide();
    }else{
        $('#gruposAntiguos').show();
        $('#gruposActuales').hide();
    }
}