function confirmarGuardarHorario() {
    document.getElementById("horaFinS").value =
        document.getElementById("horaFin").value + ":00";
    document.getElementById("horaInicioS").value =
        document.getElementById("horaInicio").value + ":00";
    document.getElementById("diaS").value = document.getElementById(
        "dia"
    ).value;
    document.getElementById("rolId").value = document.getElementById(
        "tipoAcademico"
    ).value;
    if (confirm("¿Estás seguro de guardar esta porción de horario?"))
        document.getElementById("guardar-horario").submit();
}
let numFilas = document.getElementById("cuerpo-tabla").rows.length;

function vistaGrupo(id) {
    location.href = "/grupo/" + id;
}
function añadirHorario() {
    $("#cuerpo-tabla").append(
        `<tr id="` +
            numFilas +
            `">
            <td class="border border-dark">
                
                <select name ="dia" id= "dia"> 
                    <option value="LUNES">LUNES</option>
                    <option value="MARTES">MARTES</option>
                    <option value="MIERCOLES">MIERCOLES</option>
                    <option value="JUEVES">JUEVES</option>
                    <option value="VIERNES">VIERNES</option>
                    <option value="SABADO">SABADO</option>
                    </select>
                    hora inicio:
                    <input type="time" name="hora_inicio" id="horaInicio" onchange="setHoraFin()" required>
                    hora fin:
                    <input type="time" name="hora_fin" id="horaFin" disabled>
                    periodos:
                    <input type="number" id="periodo" min="1" max="12" value="1" onchange="setHoraFin()">
                    </td>
                    <td class="border border-dark">
                        <select id="tipoAcademico" name="rol_id">
                            <option value="3">DOCENCIA</option>
                            <option value="2">AUXILIATURA</option>
                            </select>
                            </td>
                            <td class="border border-dark">
                                <input width="30rem" height="30rem" type="image" src="/icons/aceptar.png" alt="Aceptar" onclick="confirmarGuardarHorario()">
                                
                                <input width="30rem" height="30rem" type="image" name="botonCancelar" src="/icons/cancelar.png" alt="Cancelar" onclick = "cancelarFila(` +
            numFilas +
            `); activar()">
                                </td>
                                </tr>`
    );
    numFilas++;
}
function cancelarFila(id) {
    fila = document.getElementById(id);
    padre = fila.parentNode;
    padre.removeChild(fila);
}
function setHoraFin(horarioId = "") {
    var timeInicio = document.getElementById("horaInicio" + horarioId).value;
    var periodo = 45;
    var numPeriodos = parseInt(
        document.getElementById("periodo" + horarioId).value
    );
    var splitTimeInicio = timeInicio.split(":");
    var horaFin = parseInt(splitTimeInicio[0]);
    var minutosFin = parseInt(splitTimeInicio[1]);

    if (timeInicio != "") {
        for (var i = numPeriodos; i > 0; i--) {
            if (minutosFin + periodo >= 60) {
                minutosFin = minutosFin + periodo - 60;
                horaFin = horaFin + 1;
            } else {
                minutosFin = minutosFin + periodo;
            }
        }
        if (horaFin < 10) {
            horaFin = "0" + horaFin;
        }
        if (minutosFin < 10) {
            minutosFin = "0" + minutosFin;
        }
        document.getElementById("horaFin" + horarioId).value =
            horaFin + ":" + minutosFin;
    }
}
