function verificar_campo(user, pass){
    error = false;
    if(user.trim() === ""){
        error = true;
        alert("Por favor complete el campo de nombre de usuario.");
    }
    else if(!/^[A-Za-z0-9]/.test(user)){
        error = true;
        alert("No se permiten caracteres especiales.");
    }
    else if(pass.trim() === ""){
        error = true;
        alert("Por favor complete el campo de contraseña.");
    }
    else if(!/^[0-9A-Za-z]+$/.test(pass)){
        error = true;
        alert("No se permiten caranteres especiales.");
    }
    if(error){
        return false;
    }
    else{
        return true;
    }
}
function ingresar(user, pass){
    $.ajax({
        url: "Funciones/login.php",
        data: { 'comprobar': 'ingresar', 'usuario': user , 'password': pass },
        type: "POST",
        dataType: "json",
        success: function (data) {
            console.log("AJAX success", data);
            if(data.error === "1") {
                alert("El nombre de usuario no esta registrado");
            }
            else if(data.error === "2") {
                alert("La contraseña es incorrecta");
            }
            else if(data.error === "0") {
                alert("Usted se ha logrado ingresar a...");
                window.location.href = "home.php";
            }
        }
    });
}

function ingreso(user, pass){
    if(verificar_campo(user, pass)){
        ingresar(user, pass)
    }
}