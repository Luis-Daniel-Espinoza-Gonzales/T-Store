<?php
require_once '../env.php';

switch($_POST['comprobar']) {
    case 'logistica':

        $consulta_00 = "SELECT COUNT(*) AS total FROM (SELECT Logistica.ID FROM Logistica) AS conteo";

        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00);

        $total_resultados = 0;

        if(sqlsrv_execute($stmt_00) === false){
            echo json_encode(['error' => 'Error en conteo de consulta SQL']);
        } else if($row_00 = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
            $total_resultados = $row_00['total'];
        }

        $pagina = $_POST['pagina'];

        $consulta_01 = "SELECT Logistica.id, Productos.nombre AS producto, Transportes.tipo_transporte AS transporte, Tipo_origen.nombre AS tipo_origen, Logistica.origen, Sucursales.nombre AS destino, Logistica.fecha_salida, Logistica.fecha_llegada, Estados.nombre AS estado, Logistica.cantidad 
                        FROM Logistica
                        INNER JOIN Productos ON Productos.id = Logistica.id_producto
                        INNER JOIN Transportes ON Transportes.id = Logistica.id_transporte
                        INNER JOIN Tipo_origen ON Tipo_origen.id = Logistica.id_tipo_origen
                        INNER JOIN Sucursales ON Sucursales.id = Logistica.id_destino
                        INNER JOIN Estados ON Estados.id = Logistica.estado
                        ORDER BY Logistica.id DESC
                        OFFSET (? - 1) * 2 ROW
                        FETCH NEXT 2 ROWS ONLY";

        $stmt_01 = sqlsrv_prepare($conexion, $consulta_01, array(&$pagina));

        if(sqlsrv_execute($stmt_01) === false) {
            echo json_encode(['error' => 'Error en consulta SQL']);
            die();
        } else {
            $result = [];
            while($row = sqlsrv_fetch_array($stmt_01, SQLSRV_FETCH_ASSOC)) {

                $origen_00 = $row['origen'];
                $origen_01;
                $fecha_salida;
                $fecha_llegada;
                if($row['tipo_origen'] == 'proveedor'){
                    $consulta_02 = "SELECT razon_social FROM Proveedores WHERE id = ?";
                    $stmt_02 = sqlsrv_query($conexion, $consulta_02, array(&$origen_00));
                    sqlsrv_fetch($stmt_02);
                    $origen_01 = sqlsrv_get_field($stmt_02, 0);
                }
                else if($row['tipo_origen'] == 'sucursal'){
                    $consulta_02 = "SELECT nombre FROM Sucursales WHERE id = ?";
                    $stmt_02 = sqlsrv_query($conexion, $consulta_02, array(&$origen_00));
                    sqlsrv_fetch($stmt_02);
                    $origen_01 = sqlsrv_get_field($stmt_02, 0);
                }
                else if($row['tipo_origen'] == 'deposito'){
                    $consulta_02 = "SELECT nombre FROM Sucursales WHERE id = ?";
                    $stmt_02 = sqlsrv_query($conexion, $consulta_02, array(&$origen_00));
                    sqlsrv_fetch($stmt_02);
                    $origen_01 = sqlsrv_get_field($stmt_02, 0);
                }

                if($row['fecha_salida'] == NULL) {
                    $fecha_salida = "NULL";
                }
                else {
                    $fecha_salida = $row['fecha_salida']->format('Y-m-d');
                }

                if($row['fecha_llegada'] == NULL) {
                    $fecha_llegada = "NULL";
                }
                else {
                    $fecha_llegada = $row['fecha_llegada']->format('Y-m-d');
                }

                $result[] = [
                    'id' => $row['id'],
                    'producto' => $row['producto'],
                    'transporte' => $row['transporte'],
                    'tipo_origen' => $row['tipo_origen'],
                    'origen' => $origen_01,
                    'destino' => $row['destino'],
                    'fecha_salida' => $fecha_salida,
                    'fecha_llegada' => $fecha_llegada,
                    'estado' => $row['estado'],
                    'cantidad' => $row['cantidad']
                ];
            }
            // Envía los datos como JSON
            echo json_encode([
                'result' => $result,
                'total_resultados' => $total_resultados,
            ]);
        }
        break;

    case 'ventas':
        break;

    case 'productos':
        break;

    case 'envios':
        break;

    case 'sucursal':
        $consulta_00 = "SELECT DISTINCT Stock_sucursal.id_sucursal AS id_sucursal, Sucursales.nombre AS nombre FROM Stock_sucursal
                        INNER JOIN Sucursales ON Stock_sucursal.id_sucursal = Sucursales.id
                        ORDER BY Stock_sucursal.id_sucursal DESC";

        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00);

        if(sqlsrv_execute($stmt_00) === false) {
            echo json_encode(['error' => 'Error en consulta SQL']);
            die();
        } else {
            $result = [];
            while($row = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC)) {
                $result[] = [
                    'id' => $row['id_sucursal'],
                    'nombre' => $row['nombre'],
                ];
            }
            // Envía los datos como JSON
            echo json_encode($result);
        }

        break;


}
sqlsrv_close($conexion);
?>