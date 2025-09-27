<?php

$SERVER = "ACKERLY\SQLEXPRESS"; // Escapa la barra invertida en el nombre del servidor
//10.120.3.239 ip del servidor
$CONNECT = array(
    "Database" => "T-Store",
    "UID" => "sa", // Cambié "Usuario" a "UID"
    "PWD" => "123" // Cambié "contraseña" a "PWD"
);

// Establecer la conexión
$conexion = sqlsrv_connect($SERVER, $CONNECT);



?>