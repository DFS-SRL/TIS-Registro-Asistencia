function confirmarInvalidarAsistencia(asistenciaId) {
    if (
        confirm(
            "¿Estás seguro de invalidar esta asistencia?, no habrá marcha atrás."
        )
    )
        document.getElementById("invalidar" + asistenciaId).submit();
}
