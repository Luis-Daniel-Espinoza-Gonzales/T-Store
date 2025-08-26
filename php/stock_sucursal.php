<?php
session_start(); // Inicia la sesión
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
    <main class="main">
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="#" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="#" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="#" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="#" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>

</html>