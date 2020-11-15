$(window).on("load", function() {
    $('#todos-tab').click();
});

function mostrarTabla(id, arreglo) {
    var div = document.getElementById(id);

    var content =
        `<table class="table table-bordered">
            <tr>
                <th class="textoBlanco border border-dark">NOMBRE</th>
                <th class="textoBlanco border border-dark">ROL</th>
                <th class="textoBlanco border border-dark">CODIGO SIS</th>
            </tr>
        `;

    arreglo.forEach(
        function callback(elem, index, array) {
            content += `
                    <tr>
                        <td>` + elem.nombre + "</td>" +
                "<td>" + elem.rol_id + "</td>" +
                "<td>" + elem.codSis + "</td>" +
                "</tr>"
        }
    );

    content += "</table>";

    div.innerHTML = content;
}