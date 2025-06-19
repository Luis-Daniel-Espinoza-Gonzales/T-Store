<?php
require_once '../env.php';

switch($_POST['comprobar']) {
    case 'producto':

        $consulta_00 = "SELECT nombre FROM Productos";

        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00);

        if(sqlsrv_execute($stmt_00) === false) {
            echo json_encode(['error' => 'Error en consulta SQL']);
            die();
        } else {
            $result = [];
            while($row = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
                $result[] = [
                    'producto' => $row['nombre'],
                ];
            }
            // Envía los datos como JSON
            echo json_encode($result);
        }
        break;
    
    case 'transporte':

        $consulta_00 = "SELECT tipo_transporte FROM Transportes";

        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00);

        if(sqlsrv_execute($stmt_00) === false) {
            echo json_encode(['error' => 'Error en consulta SQL']);
            die();
        } else {
            $result = [];
            while($row = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
                $result[] = [
                    'transporte' => $row['tipo_transporte'],
                ];
            }
            // Envía los datos como JSON
            echo json_encode($result);
        }
        break;

    case 'tipo_origen':

        $consulta_00 = "SELECT nombre FROM Tipo_origen";

        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00);

        if(sqlsrv_execute($stmt_00) === false) {
            echo json_encode(['error' => 'Error en consulta SQL']);
            die();
        } else {
            $result = [];
            while($row = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
                $result[] = [
                    'tipo_origen' => $row['nombre'],
                ];
            }
            // Envía los datos como JSON
            echo json_encode($result);
        }
        break;

    case 'origen':

        $origen = $_POST['data'];

        if($origen == 'proveedor') {
            $consulta_00 = "SELECT razon_social FROM Proveedores";
        }
        else if($origen == 'sucursal') {
            $consulta_00 = "SELECT nombre FROM Sucursales WHERE id_tipo_sucursal = 1";
        }
        else if($origen == 'deposito') {
            $consulta_00 = "SELECT nombre FROM Sucursales WHERE id_tipo_sucursal = 3";
        }

        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00);

        if($origen == 'sucursal' || $origen == 'deposito') {

            if(sqlsrv_execute($stmt_00) === false) {
                echo json_encode(['error' => 'Error en consulta SQL']);
                die();
            } else {
                $result = [];
                while($row = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
                    $result[] = [
                        'nombre_origen' => $row['nombre'],
                    ];
                }

                if($origen == 'sucursal'){
                    // Envía los datos como JSON
                    echo json_encode($result);

                }else if($origen == 'deposito'){
                    // Envía los datos como JSON
                    echo json_encode(
                        'result' => $result,
                        'data' => $origen
                    );

                }
            }
        }
        else if ($origen == 'proovedores') {

            if(sqlsrv_execute($stmt_00) === false) {
                echo json_encode(['error' => 'Error en consulta SQL']);
                die();
            } else {
                $result = [];
                while($row = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
                    $result[] = [
                        'nombre_origen' => $row['razon_social'],
                    ];
                }
                // Envía los datos como JSON
                echo json_encode($result);
            }
        }
        break;
}
sqlsrv_close($conexion);
?>