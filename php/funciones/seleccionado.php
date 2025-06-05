<?php
require_once '../env.php';

switch($_POST['comprobar']) {
    case 'producto':

        $consulta_00 = "SELECT Nombre FROM Productos";

        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00);

        if(sqlsrv_execute($stmt_00) === false) {
            echo json_encode(['error' => 'Error en consulta SQL']);
            die();
        } else {
            $result = [];
            while($row = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
                $result[] = [
                    'producto' => $row['Nombre'],
                ];
            }
            // Envía los datos como JSON
            echo json_encode($result);
        }
        break;

}
sqlsrv_close($conexion);
?>