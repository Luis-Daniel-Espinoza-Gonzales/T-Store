<?php
session_start(); // Inicia la sesión

    // Verifica si el usuario ha iniciado sesión
    if (!isset($_SESSION['name'])) {
        // Si no ha iniciado sesión, redirige a login.php
        header('Location: login.php');
        exit();
    }

?>