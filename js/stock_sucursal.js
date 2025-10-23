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

                listRow.innerHTML = "<strong>" + element.nombre + "</strong>";
                listRow.id = "mostrar_0" + element.id;
                listRow.classList.add("li-001");

                listRow.onclick = function() {
                    document.querySelectorAll(".li-001").forEach(item => {
                        item.classList.remove("active");
                    });

                    listRow.classList.add("active");

                    mostrar(element.id)
                };

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

                //Creacion de la lista
                const ul = document.createElement("ul");
                ul.classList.add("detalle-producto");

                //Producto
                const li_nombre = document.createElement("li");
                li_nombre.innerHTML = "<strong>Producto: </strong>" + nombre;
                ul.appendChild(li_nombre);

                //Producto
                const li_categoria = document.createElement("li");
                li_categoria.innerHTML = "<strong>Categoria: </strong>" + categoria;
                ul.appendChild(li_categoria);

                //Producto
                const li_cantidad = document.createElement("li");
                li_cantidad.innerHTML = "<strong>Cantidad: </strong>" + cantidad;
                ul.appendChild(li_cantidad);

                //Armado de la card
                div_card_body.appendChild(ul);
                div_card.appendChild(img);
                div_card.appendChild(div_card_body);

                main.appendChild(div_card);
            });
        }
    })
}

function obtener_activo() {
    const activo = document.querySelector(".li-001.active");
    if(activo) {
        return activo.id.replace("mostrar_0", "");
    } else {
        return null;
    }
}

function agregar(productos, cantidad) {
    let id_sucursal = obtener_activo();
    console.log(id_sucursal)

}

document.addEventListener('DOMContentLoaded', function() {
    const btn_form_agregar = document.getElementById('btn_formulario_01');
    const formulario_agregar = document.getElementById('formulario_agregar');
    const btn_form_agr_ocultar = document.getElementById('btn_agr_ocultar');

    //muestra el formulario para agregar
    btn_form_agregar.addEventListener('click', () => {
        if (formulario_agregar.style.display === 'none' || formulario_agregar.style.display === '') {
            formulario_agregar.style.display = 'block'; 
        } else {
            formulario_agregar.style.display = 'none'; 
        }
    });

    //oculta el formulario de agregar
    btn_form_agr_ocultar.addEventListener('click', () => {
        formulario_agregar.style.display = 'none'; 
    });
})
