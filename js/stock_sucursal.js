function mostrar_datos() {
    $.ajax({
        url: "funciones/extraer.php",
        data: {'comprobar': 'sucursal'},
        type: "POST",
        dataType: "json",
        success: function(data) {
            console.log("AJAX success", data);
        }
    })
}