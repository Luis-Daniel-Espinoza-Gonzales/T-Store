<?php
session_start(); // Inicia la sesión
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/logistica.css">
    <script src="../js/logistica.js"></script>
    <title>Logística</title>
</head>
<body onload="mostrar_datos(1); informacion_producto(); informacion_transporte(); /*informacion_tipo_origen(); informacion_origen()*/; informacion_destino(); /*informacion_estado()*/">

    <?php
        require_once 'funciones/def_navbar.php';

        echo "<script>console.log('" . json_encode($_SESSION) . "')</script>";
    ?>

    <div class="container">
        <!-- Botón Agregar -->
    
        <!-- Formulario (inicialmente oculto) -->
        <form id="formulario" action="funciones/ingresa_logistica.php" method="POST" style="display: none;">
            <h2>Ingrese datos a agregar</h2>
           
            <label>Productos</label>
            <select id="productos_seleccion" name="Producto" required></select>

            <label>Transporte</label>
            <select id="transporte_seleccion" name="Transporte" required></select>

            <label>Tipo origen</label>
            <select id="tipo_origen_seleccion" name="Tipo_origen" required></select>

            <label>Origen</label>
            <select id="origen_seleccion" name="Origen" required></select>

            <label>Destino</label>
            <select id="destino_seleccion" name="Destino" required></select>

            <label>Fecha salida</label>
            <input type="date" id="fecha_salida" name="Salida" required>

            <label>Fecha llegada</label>
            <input type="date" id="fecha_llegada" name="Llegada" required>

            <label>Estado</label>
            <select id="estado_seleccion" name="Estado" required></select>

            <label>Cantidad</label>
            <input type="number" id="cantidad" placeholder="Cantidad" name="Cantidad" required>         

            <input type="button" id="btnSubir" onclick="
            agregar(
                document.getElementById('productos_seleccion').value,
                document.getElementById('transporte_seleccion').value,
                document.getElementById('tipo_origen_seleccion').value,
                document.getElementById('origen_seleccion').value,
                document.getElementById('destino_seleccion').value,
                document.getElementById('fecha_salida').value,
                document.getElementById('fecha_llegada').value,
                document.getElementById('estado_seleccion').value,
                document.getElementById('cantidad').value
            )
            "
            value="Ingresar">

            <input type="button" id="btnOcultar" value="Ocultar">
        </form>

        <!-- Botón Modificar -->

        <!-- Formulario (inicialmente oculto) -->
        <form id="formulario_modificar" action="funciones/modificar_logistica.php" method="POST" style="display: none;">
            <h2>Ingrese datos a modificar</h2>

            <label>Producto:</label>
            <select id="producto_modificar" name="Producto" required></select>

            <label>Transporte:</label>
            <select id="transporte_modificar" name="Transporte" required></select>

            <label>Tipo_origen</label>
            <select id="tpo_origen_modificar" name="Tipo_origen" required></select>

            <label>Origen</label>
            <select id="origen_modificar" name="Origen" required></select>

            <label>Destino</label>
            <select id="destino_modificar" name="Destino" required></select>

            <label>Fecha salida</label>
            <input type="date" id="fecha_salida_modificar" name="Salida" required>

            <label>Fecha llegada</label>
            <input type="date" id="fecha_llegada_modificar" name="Llegada" required>

            <label>Estado</label>
            <select id="estado_modificar" name="Estado" required></select>

            <label>Cantidad</label>
            <input type="number" id="cantidad_modificar" placeholder="Cantidad" name="Cantidad" required> 

            <input type="button" id="btnModificar" onclick="
            modificar(
                document.getElementById('producto_modificar').value,
                document.getElementById('transporte_modificar').value,
                document.getElementById('tipo_origen_modificar').value,
                document.getElementById('origen_modificar').value,
                document.getElementById('destino_modificar').value,
                document.getElementById('fecha_salida_modificar').value,
                document.getElementById('fecha_llegada_modificar').value,
                document.getElementById('estado_modificar').value,
                document.getElementById('cantidad_modificar').value
            )
            "
            value="Modificar">

            <input type="button" id="btnOcultarModificar" value="Ocultar">
        </form>

    </div>

    <div class="container2">
        <!-- Tabla de datos -->
        <table id="tabla_datos">
            <thead>
                <tr>
                    <button id="btnAgregar">Agregar</button> 
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Transporte</th>
                    <th>Tipo origen</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Fecha salida</th>
                    <th>Fecha llegada</th>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="cuerpo">
                <!-- Aquí se cargarán los datos -->
            </tbody>
        </table>
    </div>

    <div class="container3" id="paginacion">

    </div>
</body>
</html>