function guardarPlanilla() {
    if (
        confirm(
            "¿Estás seguro de guardar la planilla semanal?, los documentos comprobantes no serán guardados."
        )
    ) {
        form = document.getElementById("form-planilla");
        form.onsubmit = "";
        form.action = rutaPlanilla;
        form.submit();
    }
}
var permisos = [];
permisos[null] = 0;
permisos["LICENCIA"] = 1;
permisos["BAJA_MEDICA"] = 2;
permisos["DECLARATORIA_EN_COMISION"] = 3;
function cargarPlanilla(planilla, indi) {
    console.log("la planilla");
    console.log(planilla);
    id = planilla["horario_clase_id"];
    if (!planilla["asistencia"]) {
        habilitarDeshabilitar(id);
        document.getElementById("asistencia" + id).checked = false;
        permiso = permisos[planilla["permiso"]];
        document.getElementById("select" + id).selectedIndex = permiso;
        combo(permiso, id);
    }
    document.getElementById("actividad" + id).value =
        planilla["actividad_realizada"];
    document.getElementById("observacion" + id).value =
        planilla["observaciones"];
    if (indi)
        document.getElementById("verificable" + id).value =
            planilla["indicador_verificable"];

    consolo();
}
