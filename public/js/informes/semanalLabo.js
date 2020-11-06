function habilitarPermiso(id) {
    if (document.getElementById("asistencia"+id).checked == false){
        document.getElementById("columnaPermiso"+id).disabled = false;
        document.getElementById("asistenciaFalse"+id).value= false;
    } else {
        document.getElementById("columnaPermiso"+id).disabled = true;
        document.getElementById("asistenciaFalse"+id).value= true;
    }
}