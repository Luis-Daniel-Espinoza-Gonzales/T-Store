<?php
// Archivo: funciones/usuarios_api.php

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexion.php'; // Usa la conexión PDO de conexion.php

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

try {
    switch ($accion) {

        case 'listar':
            // Esta consulta es similar a la que subiste, pero se asegura de obtener 
            // los campos de Empleados para el listado.
            $sql = "SELECT 
                        u.id AS id_usuario,
                        u.nombre AS usuario_nombre,
                        u.email,
                        u.id_rol,
                        e.nombre AS emp_nombre,
                        e.apellido AS emp_apellido,
                        e.cuit,
                        e.telefono,
                        e.id_sucursal,
                        e.sueldo
                    FROM Usuarios u
                    LEFT JOIN Empleados e ON e.id_usuario = u.id
                    ORDER BY u.id DESC";
            $stmt = $pdo->query($sql);
            $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($datos);
            break;

        case 'obtener':
            $id = intval($_POST['id'] ?? 0);
            if (!$id) {
                echo json_encode(['error' => true, 'mensaje' => 'ID de usuario inválido']);
                exit;
            }
            
            $sql = "SELECT u.id, u.nombre, u.email, u.id_rol, 
                           e.nombre AS emp_nombre, e.apellido, e.cuit, e.telefono, e.id_sucursal, e.sueldo
                    FROM Usuarios u
                    LEFT JOIN Empleados e ON e.id_usuario = u.id
                    WHERE u.id = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($datos) {
                echo json_encode($datos);
            } else {
                echo json_encode(['error' => true, 'mensaje' => 'Usuario no encontrado']);
            }
            break;
            
        case 'crear':
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $id_rol = intval($_POST['id_rol'] ?? 0);
            
            // Campos de empleado (opcionales)
            $emp_nombre = $_POST['emp_nombre'] ?? null;
            $apellido = $_POST['apellido'] ?? null;
            $cuit = $_POST['cuit'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $sueldo = $_POST['sueldo'] ?? null;
            $id_sucursal = $_POST['id_sucursal'] ?? null;
            
            if (!$nombre || !$email || !$contrasena || !$id_rol) {
                 echo json_encode(['error' => true, 'mensaje' => 'Faltan campos obligatorios para el usuario.']);
                 exit;
            }

            $pass = $contrasena; 

            $pdo->beginTransaction();
            try {
                // 1. Insertar en Usuarios
                $sqlUsuario = "INSERT INTO Usuarios (nombre, email, contrasena, fecha_creacion, id_rol) 
                               VALUES (?, ?, ?, GETDATE(), ?)"; 
                $stmtUsuario = $pdo->prepare($sqlUsuario);
                $stmtUsuario->execute([$nombre, $email, $pass, $id_rol]);
                
                // Obtener el ID del nuevo usuario. NOTA: lastInsertId() podría requerir ajuste en SQL Server con PDO, 
                // dependiendo del driver y la configuración. Se asume que funciona o se usa SCOPE_IDENTITY() si es necesario.
                $id_usuario = $pdo->lastInsertId();

                // 2. Si el rol no es Cliente (ID 4), insertar en Empleados
                if ($id_rol !== 4) {
                    $sqlEmpleado = "INSERT INTO Empleados (nombre, apellido, cuit, telefono, id_sucursal, fecha_alta, sueldo, id_usuario)
                                    VALUES (?, ?, ?, ?, ?, GETDATE(), ?, ?)";
                    $stmtEmpleado = $pdo->prepare($sqlEmpleado);
                    $stmtEmpleado->execute([
                        $emp_nombre, 
                        $apellido, 
                        $cuit, 
                        $telefono, 
                        $id_sucursal, 
                        $sueldo, 
                        $id_usuario
                    ]);
                }

                $pdo->commit();
                echo json_encode(['error' => false, 'mensaje' => 'Usuario/Empleado creado correctamente.']);
            } catch (PDOException $e) {
                $pdo->rollBack();
                if ($e->getCode() == '23000') {
                    echo json_encode(['error' => true, 'mensaje' => 'Error: El nombre de usuario o email ya existe.']);
                } else {
                    echo json_encode(['error' => true, 'mensaje' => 'Error al crear: ' . $e->getMessage()]);
                }
            }
            break;

        case 'editar':
            $id_usuario = intval($_POST['id'] ?? 0);
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $contrasena = $_POST['contrasena'] ?? ''; // Opcional
            $id_rol = intval($_POST['id_rol'] ?? 0);
            
            // Campos de empleado
            $emp_nombre = $_POST['emp_nombre'] ?? null;
            $apellido = $_POST['apellido'] ?? null;
            $cuit = $_POST['cuit'] ?? null;
            $telefono = $_POST['telefono'] ?? null;
            $sueldo = $_POST['sueldo'] ?? null;
            $id_sucursal = $_POST['id_sucursal'] ?? null;
            
            if (!$id_usuario || !$nombre || !$email || !$id_rol) {
                 echo json_encode(['error' => true, 'mensaje' => 'Faltan campos obligatorios para actualizar.']);
                 exit;
            }

            $pdo->beginTransaction();
            try {
                // 1. Actualizar Usuarios
                $sqlUsuario = "UPDATE Usuarios SET nombre = ?, email = ?, id_rol = ?";
                $paramsUsuario = [$nombre, $email, $id_rol];
                
                // Si hay contraseña, añadirla a la actualización
                if (!empty($contrasena)) {
                    $pass = $contrasena; 
                    $sqlUsuario .= ", contrasena = ?";
                    $paramsUsuario[] = $pass;
                }
                
                $sqlUsuario .= " WHERE id = ?";
                $paramsUsuario[] = $id_usuario;
                
                $stmtUsuario = $pdo->prepare($sqlUsuario);
                $stmtUsuario->execute($paramsUsuario);
                
                // 2. Manejar Empleados
                $es_empleado = $id_rol !== 4;
                
                // Verificar si ya existe un registro de Empleado
                $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM Empleados WHERE id_usuario = ?");
                $stmtCheck->execute([$id_usuario]);
                $existeEmpleado = $stmtCheck->fetchColumn() > 0;
                
                if ($es_empleado) {
                    if ($existeEmpleado) {
                        // Actualizar Empleados
                        $sqlEmpleadoUpdate = "UPDATE Empleados 
                                              SET nombre = ?, apellido = ?, cuit = ?, telefono = ?, id_sucursal = ?, sueldo = ? 
                                              WHERE id_usuario = ?";
                        $stmtEmpleadoUpdate = $pdo->prepare($sqlEmpleadoUpdate);
                        $stmtEmpleadoUpdate->execute([$emp_nombre, $apellido, $cuit, $telefono, $id_sucursal, $sueldo, $id_usuario]);
                    } else {
                        // Insertar en Empleados (Cliente pasa a ser Empleado)
                        $sqlEmpleadoInsert = "INSERT INTO Empleados (nombre, apellido, cuit, telefono, id_sucursal, fecha_alta, sueldo, id_usuario)
                                              VALUES (?, ?, ?, ?, ?, GETDATE(), ?, ?)";
                        $stmtEmpleadoInsert = $pdo->prepare($sqlEmpleadoInsert);
                        $stmtEmpleadoInsert->execute([$emp_nombre, $apellido, $cuit, $telefono, $id_sucursal, $sueldo, $id_usuario]);
                    }
                } elseif (!$es_empleado && $existeEmpleado) {
                    // Si pasa a ser Cliente y era Empleado, eliminar el registro de Empleados
                    $pdo->prepare("DELETE FROM Empleados WHERE id_usuario = ?")->execute([$id_usuario]);
                }

                $pdo->commit();
                echo json_encode(['error' => false, 'mensaje' => 'Actualizado correctamente']);
            } catch (PDOException $e) {
                $pdo->rollBack();
                if ($e->getCode() == '23000') {
                    echo json_encode(['error' => true, 'mensaje' => 'Error: El nombre de usuario o email ya existe.']);
                } else {
                    echo json_encode(['error' => true, 'mensaje' => 'Error al actualizar: ' . $e->getMessage()]);
                }
            }
            break;

        case 'eliminar':
            
            $id_usuario = intval($_POST['id'] ?? 0);
            if (!$id_usuario) {
                echo json_encode(['error' => true, 'mensaje' => 'ID inválido']);
                exit;
            }

            $pdo->beginTransaction();
            try {
                // 1. Eliminar de Empleados (si existe)
                $pdo->prepare("DELETE FROM Empleados WHERE id_usuario = ?")->execute([$id_usuario]);
                
                // 2. Eliminar de Usuarios
                $pdo->prepare("DELETE FROM Usuarios WHERE id = ?")->execute([$id_usuario]);

                $pdo->commit();
                echo json_encode(['error' => false, 'mensaje' => 'Eliminado correctamente']);
            } catch (PDOException $e) {
                $pdo->rollBack();
                echo json_encode(['error' => true, 'mensaje' => 'Error al eliminar: ' . $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(['error' => true, 'mensaje' => 'Acción no definida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => true, 'mensaje' => 'Error general del sistema: ' . $e->getMessage()]);
}
?>