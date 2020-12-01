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