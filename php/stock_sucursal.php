<?php
session_start(); // Inicia la sesión
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/stock_sucursal.css">
</head>
<body>
    <?php
        require_once 'funciones/def_navbar.php';

        echo "<script>console.log('" . json_encode($_SESSION) . "')</script>";
    ?>
    <nav class="navbar">
        <ul class="ul-001">
            <li class="li-001">addslashes</li>
            <li class="li-001">addslashes</li>
            <li class="li-001">addslashes</li>
        </ul>
    </nav>
    <main class="main">
        
    </main>
    <footer>

    </footer>
</body>
</html>