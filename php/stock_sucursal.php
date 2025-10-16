<?php
session_start(); // Inicia la sesión
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
        <div class="options">
            <button class="option">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>
            <button class="option">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>
        <div class="main" id="main">

        </div>
    </main>
    <footer>

    </footer>
</body>

</html>