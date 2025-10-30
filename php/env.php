<?php

<<<<<<< HEAD
$SERVER = "DESKTOP-E982PIO\SQLEXPRESS"; // Escapa la barra invertida en el nombre del servidor
=======
$SERVER = "DESKTOP-CD75KS2\SQLEXPRESS"; // Escapa la barra invertida en el nombre del servidor
>>>>>>> 9f1ade2ce00401cff28b1f322ddff09ad6310f07
//10.120.3.239 ip del servidor
$CONNECT = array(
    "Database" => "T-Store",
    "UID" => "sa", // Cambié "Usuario" a "UID"
    "PWD" => "1234" // Cambié "contraseña" a "PWD"
);

// Establecer la conexión
$conexion = sqlsrv_connect($SERVER, $CONNECT);



?>