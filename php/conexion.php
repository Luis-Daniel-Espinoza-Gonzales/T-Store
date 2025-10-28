<?php

define('DB_SERVER', 'DESKTOP-KDP373U'); 
define('DB_NAME', 'T-Store');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');

try {
    
    $dsn = "sqlsrv:Server=" . DB_SERVER . ";Database=" . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Opcional: forzar fetch assoc por defecto
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    
    die("Error al conectar con la base de datos: " . $e->getMessage());
}