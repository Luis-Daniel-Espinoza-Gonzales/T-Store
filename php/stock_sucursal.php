<?php
    require_once 'funciones/deteccion_session.php'
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/stock_sucursal.css">
    <script src="../js/stock_sucursal.js"></script>
</head>

<body onload="mostrar_datos()">
    <?php
    require_once 'funciones/def_navbar.php';

    echo "<script>console.log('" . json_encode($_SESSION) . "')</script>";
    ?>
    <nav class="navbar">
        <ul class="ul-001" id="list">
            <li class="li-001">addslashes</li>
            <li class="li-001">addslashes</li>
            <li class="li-001">addslashes</li>
        </ul>
    </nav>
    <main>

        <!-- Formulario (inicialmente oculto) -->
        <form id="formulario_agregar" method="POST" style="display: none;">
            <h2>Seleccione para agregar producto a la sucursal</h2>

            <label>Productos</label>
            <select id="productos_seleccion" name="Producto" required></select>

            <label>Cantidad</label>
            <input type="number" id="cantidad" placeholder="Cantidad" name="Cantidad" required>   

            <input type="button" id="btn_agregar" onclick="agregar(
            document.getElementById('productos_seleccion').value,
            document.getElementById('cantidad').value
            )"
            value="Agregar">

            <input type="button" id="btn_agr_ocultar" value="Ocultar">
        </form>

        <div class="options" id="container_00" style="display: none;">
            <button class="option" id="btn_formulario_01">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>
            <button class="option" id="btn_formulario_02">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <div class="main" id="main">
            <h1>Seleccione alguna sucursal</h1>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>