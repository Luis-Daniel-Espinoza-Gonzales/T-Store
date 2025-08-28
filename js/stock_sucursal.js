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

            data.forEach(element => {
                const listRow = document.createElement("li");

                listRow.textContent = element.nombre;
                listRow.id = "mostrar_0" + element.id;
                listRow.onclick = function() { mostrar(element.id)};
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

            const main = document.getElementById("main");
            main.innerHTML = "";

            data.forEach(element => {

                x = element.id;
                nombre = element.nombre;
                categoria = element.categoria;
                cantidad = element.cantidad;

                //Creacion del div principal
                const div_card = document.createElement("div");
                div_card.classList.add("card");
                div_card.style.width = '14rem';

                //Creacion de la img y asignamiento de atributos
                const img = document.createElement("img");
                img.classList.add("card-img-top");
                img.src = "https://res.cloudinary.com/dcroe7hre/image/upload/" + x + "?_a=BAMAK+a60";
                img.alt = "Card image cap";

                //Creacion div body
                const div_card_body = document.createElement("div");
                div_card_body.classList.add("card-body");

                //Creacion parrafo
                const p = document.createElement("p");
                p.classList.add("card-text");
                p.textContent = nombre + "Categoria: " + categoria + "Cantidad: " + cantidad;

                //Armado de la card
                div_card_body.appendChild(p);
                div_card.appendChild(img);
                div_card.appendChild(div_card_body);

                main.appendChild(div_card);
            });
        }
    })
}