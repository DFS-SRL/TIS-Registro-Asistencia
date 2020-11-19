var section = $('#todos-tab');

if (typeof(Storage) !== "undefined") {
    if (localStorage.section){
        section = $('#' + localStorage.section)
    }else{
        localStorage.setItem("section", "todos-tab");
    }
}

$(window).on("load", function() {
    section.click();
});

function mostrarTabla(id, arreglo, todos) {
    var div = document.getElementById(id+'-content');

    var content =
        `<table class="table table-bordered">
            <tr>
                <th class="textoBlanco border border-dark">NOMBRE</th>`;
        if(todos)
            content = content + '<th class="textoBlanco border border-dark">ROL</th>'
            
        content = content + `<th class="textoBlanco border border-dark">CODIGO SIS</th>
            </tr>
        `;

    arreglo.forEach(
        function callback(elem, index, array) {
            content += `
                    <tr>
                        <td>` + elem.nombre + "</td>";
            if(todos){
                let rs = "";
                elem.roles.forEach(
                    function callback(rol, i, roles){
                        rs += i != 0 ? ", " : "";
                        rs += rol.nombre.replaceAll('-', ' ');
                    }
                );
                content += "<td>" + rs + "</td>";
            }
            content += "<td>" + elem.codSis + "</td>" +
                "</tr>"
        }
    );

    content += "</table>";

    div.innerHTML = content;
}