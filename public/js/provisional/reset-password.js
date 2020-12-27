function validate(){
    var form = $("#reset-form");
    var pass = $("#new-password");
    var rep = $("#repeat-password");
    var msg = $('#message');
    msg.addClass("d-none");
    if(pass.val() !== rep.val()){
        msg.removeClass("d-none");
        msg.text("Las contraseñas no coinciden.");
    }else if(pass.val().length < 8){
        msg.removeClass("d-none");
        msg.text("Por seguridad ingresa una contraseña de al menos 8 caracteres.");
    }else if(!esSegura(pass.val())){
        msg.removeClass("d-none");
        msg.text("Tu contraseña debería tener al menos 3 dígitos y 1 mayúscula.");
    }else{
        form.submit();
        // console.log('Listo para el submit');
    }
}

function esSegura(cadena){
    let mayus = 0;
    let dig = 0;
    for(let i = 0; i < cadena.length; i++){
        if(esNumero(cadena.charAt(i)))
            dig++;
        
        if(esMayuscula(cadena.charAt(i)))
            mayus++;
    }
    return mayus >= 1 && dig >= 3;
}

function esNumero(car){
    return car >= '0' && car <= '9';
}

function esMayuscula(car){
    return car >= 'A' && car <= 'Z';
}