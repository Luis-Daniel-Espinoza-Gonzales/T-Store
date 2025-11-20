<?php

// **CÓDIGO CORREGIDO para env.php (Sin conflictos de Git y con la instancia correcta)**
$SERVER = "DESKTOP-KDP373U\\Escuela Tecnica 26"; 

//10.120.3.239 ip del servidor
$CONNECT = array(
    "Database" => "T-Store",
    "UID" => "sa", // Asegúrate de que este sea el usuario correcto
    "PWD" => "1234" // Asegúrate de que esta sea la contraseña correcta
);

// Establecer la conexión
$conexion = sqlsrv_connect($SERVER, $CONNECT);

// **Añadir manejo de error para sqlsrv_connect**
if ($conexion === false) {
    die(print_r(sqlsrv_errors(), true));
}

?>