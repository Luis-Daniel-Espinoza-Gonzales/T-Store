function mostrar_datos(result){
    $.ajax({
        url: "funciones/extraer.php",
        data: { 'comprobar': 'logistica', 'pagina': result},
        type: "POST",
        dataType: "JSON",
        success: function(data) {

            console.log("AJAX success", data);
            const tbody = document.getElementById("cuerpo");
            tbody.innerHTML = "";

            data.result.forEach(row => {
                const tableRow = document.createElement("tr");

                const cellId = document.createElement("td");
                cellId.textContent = row.id;
                tableRow.appendChild(cellId);

                const cellProducto = document.createElement("td");
                cellProducto.textContent = row.producto;
                tableRow.appendChild(cellProducto);

                const cellTransporte = document.createElement("td");
                cellTransporte.textContent = row.transporte;
                tableRow.appendChild(cellTransporte);

                const cellTipo_origen = document.createElement("td");
                cellTipo_origen.textContent = row.tipo_origen;
                tableRow.appendChild(cellTipo_origen);

                const cellOrigen = document.createElement("td");
                cellOrigen.textContent = row.origen;
                tableRow.appendChild(cellOrigen);

                const cellDestino = document.createElement("td");
                cellDestino.textContent = row.destino;
                tableRow.appendChild(cellDestino);

                const cellSalida = document.createElement("td");
                cellSalida.textContent = row.fecha_salida;
                tableRow.appendChild(cellSalida);

                const cellLlegada = document.createElement("td");
                cellLlegada.textContent = row.fecha_llegada;
                tableRow.appendChild(cellLlegada);

                const cellEstado = document.createElement("td");
                cellEstado.textContent = row.estado;
                tableRow.appendChild(cellEstado);

                const cellCantidad= document.createElement("td");
                cellCantidad.textContent = row.cantidad;
                tableRow.appendChild(cellCantidad);

                const editCell = document.createElement("td");
                const btnEliminar = document.createElement("button");
                btnEliminar.textContent = "Eliminar";
                btnEliminar.classList.add("btn_eliminar");
                btnEliminar.id = "eliminar_0" + row.id;
                btnEliminar.onclick = function() { eliminar(row.id, tableRow)};
                editCell.appendChild(btnEliminar);
                tableRow.appendChild(editCell);

                const modifyCell = document.createElement("td");
                const btnModificar = document.createElement("button");
                btnModificar.textContent = "Modificar";
                btnModificar.classList.add("btn_modificar");
                btnModificar.id = "modificar_0" + row.id;
                modifyCell.appendChild(btnModificar);
                
                tableRow.appendChild(modifyCell);

                tbody.appendChild(tableRow);
            });

            console.log("total resultados: ", data.total_resultados);
            var total_result = data.total_resultados;
            var max_resultado = 2;

            var total_pagina = Math.ceil(total_result / max_resultado);
            console.log("total de paginas: ", total_pagina);

            const contenedor = document.getElementById("paginacion");
            contenedor.innerHTML = "";

            for (let i = 1; i <= total_pagina; i++) {
                const btnPagina = document.createElement("button");
                btnPagina.textContent = i;
                btnPagina.classList.add("btn_pagina");
                btnPagina.id = "pagina_0" + i;
                btnPagina.onclick = function() { cambiar_pagina(i)};
                contenedor.appendChild(btnPagina);

            }
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud AJAX:", error);
        }
    });
}

function cambiar_pagina(pagina) {
    console.log("cambiando a la pagina " + pagina);

    mostrar_datos(pagina);
}

function informacion_producto(){
    $.ajax({
        url: "funciones/seleccionado.php",
        data: { 'comprobar': 'producto' },
        type: "POST",
        dataType: "json",
        success: function(data) {
            console.log("AJAX success", data);
            const select = document.getElementById("productos_seleccion");
            select.innerHTML = "<option disabled selected>Seleccione un producto</option>";

            data.forEach(row => {
                const option = document.createElement("option");
                option.textContent = row.producto;
                select.appendChild(option);
            })
        }
    })
}

function informacion_transporte(){
    $.ajax({
        url: "funciones/seleccionado.php",
        data: { 'comprobar': 'transporte' },
        type: "POST",
        dataType: "json",
        success: function(data) {
            console.log("AJAX success", data);
            const select = document.getElementById("transporte_seleccion");
            select.innerHTML = "<option disabled selected>Seleccione un transporte</option>";

            data.forEach(row => {
                const option = document.createElement("option");
                option.textContent = row.transporte;
                select.appendChild(option);
            })
        }
    })
}

function informacion_tipo_origen(){
    $.ajax({
        url: "funciones/seleccionado.php",
        data: { 'comprobar': 'tipo_origen' },
        type: "POST",
        dataType: "json",
        success: function(data) {
            console.log("AJAX success", data);
            const select = document.getElementById("tipo_origen_seleccion");
            select.innerHTML = "<option disabled selected>Seleccione un tipo de origen</option>";

            data.forEach(row => {
                const option = document.createElement("option");
                option.textContent = row.tipo_origen;
                select.appendChild(option);
            })
        }
    })
}

function informacion_origen(){
    $.ajax({
        url: "funciones/seleccionado.php",
        data: { 'comprobar': 'origen' },
        type: "POST",
        dataType: "json",
        success: function(data) {
            console.log("AJAX success", data);
            const select = document.getElementById("origen_seleccion");
            select.innerHTML = "<option disabled selected>Seleccione un origen</option>";

            data.forEach(row => {
                const option = document.createElement("option");
                option.textContent = row.tipo_origen;
                select.appendChild(option);
            })
        }
    })
}

function informacion_destino(){}

function informacion_estado(){}

function eliminar(id, tableRow) {

    
    if (!confirm("¿Estás seguro de que deseas eliminar este registro?")) {
        return;
    }

    console.log("eliminando", id);

    $.ajax({
        url: "funciones/eliminar_registro.php",
        data: { 'comprobar': 'logistica', 'id': id },
        type: "POST",
        dataType: "json",
        success: function(response) {
            if(response.success){

                tableRow.remove();
                console.log("Registro eliminado exitosamente.");
            } else {

                console.error("Error en la eliminación:", response.error);

            }
        }
    })
    location.reload();
};

function agregar( producto, transporte, tipo_origen, origen, destino, fecha_salida, fecha_llegada, estado, cantidad) {

    if(!confirm("¿Estás seguro de que deseas agregar un nuevo registro?")) {
        return;
    }

    $.ajax({
        url: "funciones/agregado_registro.php",
        data: { 'comprobar' : 'logistica', 'transporte' : transporte, 'fecha' : fecha_ingreso, 'producto' : producto, 'cantidad' : cantidad, 'destino' : destino},
        type: "POST",
        dataType: "json",
        success: function(response) {

            if(response.success){

                console.log("Registro agregado exitosamente. ");
            } else {

                console.error("Error en el agregado: ", response.error);

            }
        }
    })
    location.reload();
};

function Modificar(id, transporte, fecha, producto, cantidad, destino) {
    const datos = new FormData();
    datos.append('id', id);
    datos.append('fecha', fecha);
    datos.append('producto', producto);
    datos.append('cantidad', cantidad);
    datos.append('transporte', transporte); 
    datos.append('destino', destino);       

    fetch('funciones/modificar_registro.php', {
        method: 'POST',
        body: datos
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Registro actualizado correctamente.");
            location.reload();
        } else {
            alert("Error: " + data.error);
        }
    })
    .catch(error => {
        alert("Error de red: " + error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const btnAgregar = document.getElementById('btnAgregar');
    const formulario = document.getElementById('formulario');
    const btnOcultar = document.getElementById('btnOcultar');
    
   
    if (!btnAgregar || !formulario || !btnOcultar) {
        console.error("No se encontraron los elementos en el DOM.");
        return;
    }

    btnAgregar.addEventListener('click', () => {
        if (formulario.style.display === 'none' || formulario.style.display === '') {
            formulario.style.display = 'block'; 
        } else {
            formulario.style.display = 'none'; 
        }
    });

    btnOcultar.addEventListener('click', () => {
        formulario.style.display = 'none'; 
    });    
 
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('btn_modificar')) {

            const formulario_modificar = document.getElementById('formulario_modificar');
            const btnOcultar_modificar = document.getElementById('btnOcultarModificar');
            const boton = event.target;
    
            const fila = boton.closest('tr');
            const celdas = fila.querySelectorAll('td');
    
            formulario_modificar.style.display = 'block';
            formulario_modificar.querySelector('input').focus();
        }
    });
    
    const btnModificarEnviar = document.getElementById('btnModificar');
    
    btnModificarEnviar.addEventListener('click', function() {
        const formularioModificar = document.getElementById('formulario_modificar');
    
        const id = formularioModificar.querySelector('[name="id"]').value.trim();
        const transporte = formularioModificar.querySelector('[name="transporte"]').value.trim();
        const fecha = formularioModificar.querySelector('[name="fecha"]').value.trim();
        const producto = formularioModificar.querySelector('[name="producto"]').value.trim();
        const cantidad = formularioModificar.querySelector('[name="cantidad"]').value.trim();
        const destino = formularioModificar.querySelector('[name="destino"]').value.trim();
    
        if (!id || !transporte || !fecha || !producto || !cantidad || !destino) {
            alert("Por favor, complete todos los campos.");
            return;
        }
    
        Modificar(id, transporte, fecha, producto, cantidad, destino);
    
        formularioModificar.style.display = "none"; 
    });
    
    document.getElementById('btnOcultarModificar').addEventListener('click', function() {
        document.getElementById('formulario_modificar').style.display = 'none';
    });

    formulario.addEventListener('submit', function(event) {
        event.preventDefault();

        // Verifica si todos los campos están llenos
        let allFilled = true;
        Array.from(formulario.elements).forEach(element => {
            if (element.tagName === 'INPUT' && element.type !== 'submit' && !element.value) {
                allFilled = false;
            }
        });

        if (!allFilled) {
            alert("Por favor, complete todos los campos.");
            return;
        }

        // Confirmación antes de enviar
        const confirmacion = confirm("¿Estás seguro de que deseas ingresar estos datos?");
        if (confirmacion) {
            formulario.submit(); // Envía el formulario si se confirma
        }
    });
});