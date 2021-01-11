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

function cargarPlanilla(planilla) {
    confirm("Cargame esta (planilla) ");
    console.log("la planilla");
    console.log(planilla);
}
