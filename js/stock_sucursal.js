function mostrar_datos() {
    $.ajax({
        url: "funciones/extraer.php",
        data: {'comprobar': 'sucursal'},
        type: "POST",
        dataType: "json",
        success: function(data) {

            console.log("AJAX success", data);
            const ul = document.getElementById("list");
            ul.innerHTML= "";

            data.forEach(row => {
                const listRow = document.createElement("li");

                listRow.textContent = row.nombre;
                listRow.id = "mostrar_0" + row.id;
                listRow.onclick = function() { mostrar(row.id)};
                listRow.classList.add("li-001");
                ul.appendChild(listRow);

            });
        }
    })
}
function mostrar(id) {
    $.ajax({
        url: "funciones/extraer.php",
        data: { 'comprobar' : 'stock_sucursal', 'id' : id},
        type: "POST",
        dataType: "json",
        success: function(data) {
            console.log("AJAX success", data);
        }
    })
}