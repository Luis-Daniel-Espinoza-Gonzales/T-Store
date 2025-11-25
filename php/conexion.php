<?php

// CAMBIO CRUCIAL: Se añade la instancia \Escuela Tecnica 26
// Si usas un backslash en el string, debes escaparlo con otro backslash (\\)
define('DB_SERVER', 'DESKTOP-5FV3BF7\SQLEXPRESS'); 
define('DB_NAME', 'T-Store');
// Asegúrate de usar tus credenciales de usuario reales, no 'tu_usuario' y 'tu_contraseña'
define('DB_USER', 'sa'); // Usaré 'sa' como ejemplo, pero usa el que tienes configurado
define('DB_PASS', '1234'); // Usaré '1234' como ejemplo, pero usa el que tienes configurado

try {
    
    // El DSN se construye ahora con el nombre de la instancia
    $dsn = "sqlsrv:Server=" . DB_SERVER . ";Database=" . DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    
    // Esto mostrará el error específico si el problema es la contraseña o el usuario (o red)
    die("Error al conectar con la base de datos: " . $e->getMessage()); 
}