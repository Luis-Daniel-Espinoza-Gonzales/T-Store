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

    const select_00 = document.getElementById("tipo_origen_seleccion");
    const valor_seleccionado = "";

    select_00.addEventListener("change", function () {

        const valor_seleccionado = this.value;
        console.log("Seleccionaste: ", valor_seleccionado)

        if(valor_seleccionado) {
            $.ajax({
                url: "funciones/seleccionado.php",
                data: { 'comprobar': 'origen', 'data': valor_seleccionado},
                type: "POST",
                dataType: "json",
                success: function(data) {
                    console.log("AJAX success", data);
                    const select_01 = document.getElementById("origen_seleccion");
                    select_01.innerHTML = "<option disabled selected>Seleccione un origen</option>";
                    select_01.disabled = false;

                    if(data.origen == 'proveedor') {
                        data.result.forEach(row => {
                            const option = document.createElement("option");
                            option.textContent = row.nombre_origen;
                            select_01.appendChild(option);
                        })
                    }
                    else if(data.origen == 'sucursal') {
                        data.result.forEach(row => {
                            const option = document.createElement("option");
                            option.textContent = row.nombre_origen;
                            select_01.appendChild(option);
                        })
                    }
                    else if(data.origen == 'deposito') {
                        data.result.forEach(row => {
                            const option = document.createElement("option");
                            option.textContent = row.nombre_origen;
                            select_01.appendChild(option);
                        })
                    }
                }
            })
        } else {
            select.disabled = true;
        }
    });     
}

function informacion_destino(){

    const select_00 = document.getElementById("origen_seleccion");
    const valor_seleccionado = "";

    select_00.addEventListener("change", function () {

        const valor_seleccionado = this.value;
        console.log("Seleccionaste: ", valor_seleccionado)

        if(valor_seleccionado) {
    
            $.ajax({
                url: "funciones/seleccionado.php",
                data: { 'comprobar': 'destino', 'data': valor_seleccionado },
                type: "POST",
                dataType: "json",
                success: function(data) {
                    console.log("AJAX success", data);
                    const select_01 = document.getElementById("destino_seleccion");
                    select_01.innerHTML = "<option disabled selected>Seleccione un destino</option>";

                    data.forEach(row => {
                        const option = document.createElement("option");
                        option.textContent = row.destino;
                        select_01.appendChild(option);
                    })
                }
            })    
        } else {
            select.disabled = true;
        }
    })
}

function informacion_estado(){
    $.ajax({
        url: "funciones/seleccionado.php",
        data: { 'comprobar': 'estado'},
        type: "POST",
        dataType: "json",
        success: function(data) {
            console.log("AJAX success", data);
            const select_00 = document.getElementById("estado_seleccion");
            select_00.innerHTML = "<option disabled selected>Seleccione el estado</option>";

            data.forEach(row => {
                const option = document.createElement("option");
                option.textContent = row.estado;
                select_00.appendChild(option);
            })
        }
    })
}

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

    id_empleado = 0;

    $.ajax({})

    $.ajax({
        url: "funciones/agregado_registro.php",
        data: { 'comprobar' : 'logistica', 'producto' : producto, 'transporte' : transporte, 'tipo_origen' : tipo_origen, 'origen' : origen, 'destino' : destino, 'fecha_salida' : fecha_salida, 'fecha_llegada' : fecha_llegada, 'estado' : estado, 'cantidad' : cantidad, 'id_empleado' : id_empleado},
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

function Modificar(id, producto, transporte, tipo_origen, origen, destino, fecha_salida, fecha_llegada, estado, cantidad) {
    const datos = new FormData();
    datos.append('id', id);
    datos.append('producto', producto);
    datos.append('transporte', transporte);
    datos.append('tipo_origen', tipo_origen);
    datos.append('origen', origen);
    datos.append('destino', destino);
    datos.append('fecha_salida', fecha_salida);
    datos.append('fecha_llegada', fecha_llegada); 
    datos.append('estado', estado);
    datos.append('cantidad', cantidad);       

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
    
    //funcion del boton agregar para mostrar formulario
    if (!btnAgregar || !formulario || !btnOcultar) {
        console.error("No se encontraron los elementos en el DOM.");
        return;
    }

    //muestra el formulario para agregar
    btnAgregar.addEventListener('click', () => {
        if (formulario.style.display === 'none' || formulario.style.display === '') {
            formulario.style.display = 'block'; 
        } else {
            formulario.style.display = 'none'; 
        }
    });

    //oculta el formulario de agregar
    btnOcultar.addEventListener('click', () => {
        formulario.style.display = 'none'; 
    });    
 
    //funcion del boton modificar para mostrar formulario y se autocomplete con los datos de la tabla
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('btn_modificar')) {
            const formulario = document.getElementById('formulario_modificar');
            const boton = event.target;
    
            const fila = boton.closest('tr');
            const celdas = fila.querySelectorAll('td');

            formulario.querySelector('[name="id"]').value = celdas[0].textContent.trim();
            formulario.querySelector('[name="productos_modificar"]').value = celdas[1].textContent.trim();
            formulario.querySelector('[name="transporte_modificar"]').value = celdas[2].textContent.trim();
            formulario.querySelector('[name="tipo_origen_modificar"]').value = celdas[3].textContent.trim();
            formulario.querySelector('[name="origen_modificar"]').value = celdas[4].textContent.trim();
            formulario.querySelector('[name="destino_modificar"]').value = celdas[5].textContent.trim();
            formulario.querySelector('[name="fecha_salida_modificar"]').value = celdas[6].textContent.trim();
            formulario.querySelector('[name="fecha_llegada_modificar"]').value = celdas[7].textContent.trim();
            formulario.querySelector('[name="estado_modificar"]').value = celdas[8].textContent.trim();
            formulario.querySelector('[name="cantidad_modificar"]').value = celdas[9].textContent.trim();
    
            formulario_modificar.style.display = 'block';
            formulario_modificar.querySelector('input').focus();
        }
    });
    
    const btnModificarEnviar = document.getElementById('btnModificar');
    
    //funcion para verificar que los campos esten conpletos y llamar a la funcion modificar
    btnModificarEnviar.addEventListener('click', function() {
        const formularioModificar = document.getElementById('formulario_modificar');
    
        const producto = formularioModificar.querySelector('[name="productos_modificar"]').value.trim();
        const transporte = formularioModificar.querySelector('[name="transporte_modificar"]').value.trim();
        const tipo_origen = formularioModificar.querySelector('[name="tipo_origen_modificar"]').value.trim();
        const origen = formularioModificar.querySelector('[name="origen_modificar"]').value.trim();
        const destino = formularioModificar.querySelector('[name="destino_modificar"]').value.trim();
        const fecha_salida = formularioModificar.querySelector('[name="fecha_salida_modificar"]').value.trim();
        const fecha_llegada = formularioModificar.querySelector('[name="fecha_llegada_modificar"]').value.trim();
        const estado = formularioModificar.querySelector('[name="estado_modificar"]').value.trim();
        const cantidad = formularioModificar.querySelector('[name="cantidad_modificar"]').value.trim();
    
        if (!id || !producto || !transporte || !tipo_origen || !origen || !destino || !fecha_salida || !fecha_llegada || !estado || !cantidad) {
            alert("Por favor, complete todos los campos.");
            return;
        }
    
        Modificar(producto, transporte, tipo_origen, origen, destino, fecha_salida, fecha_llegada, estado, cantidad);
    
        formularioModificar.style.display = "none"; 
    });
    
    //oculta el formulario modificar
    document.getElementById('btnOcultarModificar').addEventListener('click', function() {
        document.getElementById('formulario_modificar').style.display = 'none';
    });
});