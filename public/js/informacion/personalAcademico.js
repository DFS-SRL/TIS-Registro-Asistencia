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

    var content;
    
    if(arreglo.length === 0){
        content = "<h4><b>No se encontraron resultados</b></h4>"
    }else{
        content =
            `<table class="table table-bordered table-responsive">
                <tr>
                    <th class="textoBlanco border border-dark">NOMBRE</th>`;
            if(todos)
                content = content + '<th class="textoBlanco border border-dark">ROL</th>'
                
            content = content + `<th class="textoBlanco border border-dark">CODIGO SIS</th>
                </tr>
            `;
        link = '#'
        arreglo.forEach(
            function callback(elem, index, array) {
            if (todos && elem.roles[0].nombre == 'docente' || !todos && id == 'docentes')
                personal = 'docente';
            else
                personal = 'auxiliar';
            link = "http://localhost:8000/personalAcademico/" + unidad + "/" + personal + "/" + elem.codSis;
                content += `
                        <tr>
                            <td class = "border border-dark"> 
                                <a href="` + link + `">`+ elem.nombre + `</a>
                            </td>`;
                if(todos){
                    let rs = "";
                    elem.roles.forEach(
                        function callback(rol, i, roles){
                            rs += i != 0 ? ", " : "";
                            rs += rol.nombre.replaceAll('-', ' ');
                        }
                    );
                    content += `<td class = "border border-dark">` + rs + "</td>";
                }
                content += `<td class = "border border-dark">` + elem.codSis + "</td>" +
                    "</tr>"
            }
        );
    
        content += "</table>";
    }


    div.innerHTML = content;
}
// valida que el contenido de un campo de texto solo tenga letras y espacios
function validarSoloLetras(idCampoTexto, mensaje){
    let texto = document.getElementById(idCampoTexto).value
    res = true;
    for(pos = 0; pos < texto.length && res; pos++){
        res = (texto.charCodeAt(pos) >= 65 && texto.charCodeAt(pos) <= 90) //mayusculas
               || (texto.charCodeAt(pos) >= 97 && texto.charCodeAt(pos) <= 122) //minusculas
               || texto.charCodeAt(pos) == 32 //espacio
               || texto.charCodeAt(pos) == 241 //ñ 
               || texto.charCodeAt(pos) == 209 //Ñ
               || texto.charCodeAt(pos) == 225 //á
               || texto.charCodeAt(pos) == 233 //é
               || texto.charCodeAt(pos) == 237 //í
               || texto.charCodeAt(pos) == 243 //ó
               || texto.charCodeAt(pos) == 250 //ú
               || texto.charCodeAt(pos) == 205 //Í
               || texto.charCodeAt(pos) == 211 //Ó
               || texto.charCodeAt(pos) == 218 //Ú
               || texto.charCodeAt(pos) == 193 //Á
               || texto.charCodeAt(pos) == 201; //É
        console.log(texto.charCodeAt(pos));
    }
    if(!res){
        document.getElementById(mensaje).innerHTML = "Solo se puede insertar letras y espacios"
    }
    return res;
}
// valida que un campo de texto no este vacio
function validarNoVacio(idCampoTexto){
    let texto = document.getElementById(idCampoTexto).value.trim();
    return texto.length != 0;
}