<?php
session_start();
require_once '../env.php';

switch($_POST['comprobar']) {
    case 'logistica':

        $producto = $_POST['producto'];
        $id_producto = 0;
        $transporte = $_POST['transporte'];
        $id_transporte = 0;
        $tipo_origen = $_POST['tipo_origen'];
        $id_tipo_origen = 0;
        $origen = $_POST['origen'];
        $id_origen = 0;
        $destino = $_POST['destino'];
        $id_destino = 0;
        $fecha_salida = $_POST['fecha_salida'];
        $fecha_salida = date('Y-m-d', strtotime($fecha_salida));
        $fecha_llegada = $_POST['fecha_llegada'];
        $fecha_llegada = date('Y-m-d', strtotime($fecha_llegada));
        $estado = $_POST['estado'];
        $id_estado = 0;
        $cantidad = $_POST['cantidad'];
        $responsable = $_SESSION['name'];

        $ultimo_registro = "SELECT TOP 1 ID FROM Logistica ORDER BY ID DESC";
        $stmt_ultimo_registro = sqlsrv_query($conexion, $ultimo_registro);  // Realiza sqlsrv_prepare y sqlsrv_execute en uno solo (prepara la consulta y lo ejecuta)

        sqlsrv_fetch($stmt_ultimo_registro);
        $id = sqlsrv_get_field($stmt_ultimo_registro, 0); // Índice 0 = primera columna (se guarda el ultimo id registrado)
        $id += 1; // Nuevo id para registrar un nuevo campo (autoincrementado de id mediante scripts controlados)

        //extraccion de id del producto registrado
        $consulta_00 = "SELECT id FROM Productos WHERE nombre = ?";
        $stmt_00 = sqlsrv_prepare($conexion, $consulta_00, array(&$producto));

        if(sqlsrv_execute($stmt_00) === false) {
            echo json_encode(['error' => 'Error en consulta SQL con respecto a los productos']);
            die();
        } else {
            $fila = sqlsrv_fetch_array($stmt_00, SQLSRV_FETCH_ASSOC);
            $id_producto = $fila['id'];
        }

        //extraccion de id del transporte registrado
        $consulta_01 = "SELECT id FROM Transportes WHERE Tipo_Transporte = ?";
        $stmt_01 = sqlsrv_prepare($conexion, $consulta_01, array(&$transporte));

        if(sqlsrv_execute($stmt_01) === false) {
            echo json_encode(['error' => 'Error en consulta SQL con respecto a los transportes']);
            die();
        } else {
            $fila = sqlsrv_fetch_array($stmt_01, SQLSRV_FETCH_ASSOC);
            $id_transporte = $fila['id'];
        }

        //extraccion de id de tipo de origen
        $consulta_02 = "SELECT id FROM Tipo_origen WHERE nombre = ?";
        $stmt_02 = sqlsrv_prepare($conexion, $consulta_02, array(&$tipo_origen));

        if(sqlsrv_execute($stmt_02) === false) {
            echo json_encode(['error' => 'Error en consulta SQL con respecto a los tipos de origenes']);
            die();
        } else {
            $fila = sqlsrv_fetch_array($stmt_02, SQLSRV_FETCH_ASSOC);
            $id_tipo_origen = $fila['id'];
        }

        //extraccion de id de origen (ya sea proveedor, sucursal o deposito)
        if($tipo_origen == 'proveedor'){
            $consulta_03 = "SELECT id FROM Proveedores WHERE razon_social = ?";
            $stmt_03 = sqlsrv_prepare($conexion, $consulta_03, array(&$origen));

            if(sqlsrv_execute($stmt_03) === false) {
                echo json_encode(['error' => 'Error en consulta SQL con respecto al origen']);
                die();
            } else {
                $fila = sqlsrv_fetch_array($stmt_03, SQLSRV_FETCH_ASSOC);
                $id_origen = $fila['id'];
            }
        }
        else if($tipo_origen == 'sucursal' || $tipo_origen == "deposito"){
            $consulta_03 = "SELECT id FROM Sucursales WHERE nombre = ?";
            $stmt_03 = sqlsrv_prepare($conexion, $consulta_03, array(&$origen));

            if(sqlsrv_execute($stmt_03) === false) {
                echo json_encode(['error' => 'Error en consulta SQL con respecto al origen']);
                die();
            } else {
                $fila = sqlsrv_fetch_array($stmt_03, SQLSRV_FETCH_ASSOC);
                $id_origen = $fila['id'];
            }
        }

        //extraccion de id de destino
        $consulta_04 = "SELECT id FROM Sucursales WHERE nombre = ?";
        $stmt_04 = sqlsrv_prepare($conexion, $consulta_04, array(&$destino));

        if(sqlsrv_execute($stmt_04) === false) {
            echo json_encode(['error' => 'Error en consulta SQL con respecto a los tipos de origenes']);
            die();
        } else {
            $fila = sqlsrv_fetch_array($stmt_04, SQLSRV_FETCH_ASSOC);
            $id_destino = $fila['id'];
        }

        //extraccion de id del estado
        $consulta_05 = "SELECT id FROM Estados WHERE nombre = ?";
        $stmt_05 = sqlsrv_prepare($conexion, $consulta_05, array(&$estado));

        if(sqlsrv_execute($stmt_05) === false) {
            echo json_encode(['error' => 'Error en consulta SQL con respecto a los estados']);
            die();
        } else {
            $fila = sqlsrv_fetch_array($stmt_05, SQLSRV_FETCH_ASSOC);
            $id_estado = $fila['id'];
        }

        //extraccion de id del empleado quien hace el registro
        $consulta_06 = "SELECT id FROM Usuarios WHERE nombre = ?";
        $stmt_06 = sqlsrv_prepare($conexion, $consulta_06, array(&$responsable));

        if(sqlsrv_execute($stmt_06) === false) {
            echo json_encode(['error' => 'Error en consulta SQL con respecto a los estados']);
            die();
        } else {
            $fila = sqlsrv_fetch_array($stmt_06, SQLSRV_FETCH_ASSOC);
            $id_responsable = $fila['id'];
        }

        //verificacion si id existe
        $comprobar_registro = "SELECT ID FROM Logistica WHERE id = ?";
        $stmt_registro = sqlsrv_prepare($conexion, $comprobar_registro, array(&$id));

        if(sqlsrv_execute($stmt_registro) === false) {
            echo json_encode(['error' => 'Error en consulta de verificacion SQL']);
            die();
        } 

        if (sqlsrv_fetch($stmt_registro)) {
            echo json_encode(['error' => 'El ID ya existe en la base de datos.']);
            exit;
        }

        //insercion de datos
        $consulta_07 = "INSERT INTO Logistica (id, id_producto, id_transporte, id_tipo_origen, origen, id_destino, fecha_salida, fecha_llegada, estado, cantidad, id_usuario) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_07 = sqlsrv_prepare($conexion, $consulta_07, array(&$id, &$id_producto, &$id_transporte, &$id_tipo_origen, &$id_origen, &$id_destino, &$fecha_salida, &$fecha_llegada, &$id_estado, &$cantidad, &$id_responsable));

        if(sqlsrv_execute($stmt_07) === false) {
            echo json_encode(['error' => 'Error en consulta SQL']);
            die();
        } else {
            echo json_encode(['success' => true]);
        }
        break;

}
sqlsrv_close($conexion);
?>