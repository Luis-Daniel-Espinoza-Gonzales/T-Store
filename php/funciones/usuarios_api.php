<?php

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../conexion.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

try {
    switch ($accion) {

        case 'listar':
           
            $sql = "SELECT 
                        u.id AS id_usuario,
                        u.nombre AS usuario_nombre,
                        u.email,
                        u.id_rol,
                        u.fecha_creacion,
                        u.fecha_eliminacion,
                        e.id AS id_empleado,
                        e.nombre AS emp_nombre,
                        e.apellido AS emp_apellido,
                        e.cuit,
                        e.telefono,
                        e.id_sucursal,
                        e.fecha_alta,
                        e.fecha_baja,
                        e.sueldo
                    FROM Usuarios u
                    LEFT JOIN Empleados e ON e.id_usuario = u.id
                    ORDER BY u.id DESC";
            $stmt = $pdo->query($sql);
            $datos = $stmt->fetchAll();
            echo json_encode($datos);
            break;

        case 'obtener':
            $id = intval($_POST['id'] ?? 0);
            $sql = "SELECT u.*, e.id AS id_empleado, e.nombre AS emp_nombre, e.apellido, e.cuit, e.telefono, e.id_sucursal, e.fecha_alta, e.sueldo
                    FROM Usuarios u
                    LEFT JOIN Empleados e ON e.id_usuario = u.id
                    WHERE u.id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            echo json_encode($row ?: []);
            break;

        case 'crear':
           
            $usuario_nombre = trim($_POST['usuario_nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $contrasena = trim($_POST['contrasena'] ?? '');
            $id_rol = intval($_POST['id_rol'] ?? 0);

           
            $emp_nombre = trim($_POST['emp_nombre'] ?? '');
            $emp_apellido = trim($_POST['emp_apellido'] ?? '');
            $telefono = trim($_POST['telefono'] ?? null);
            $cuit = trim($_POST['cuit'] ?? null);
            $id_sucursal = $_POST['id_sucursal'] === '' ? null : intval($_POST['id_sucursal']);
            $sueldo = $_POST['sueldo'] === '' ? null : intval($_POST['sueldo']);
            $fecha_alta = $_POST['fecha_alta'] ?? null;

           
            if ($usuario_nombre === '' || $email === '' || $contrasena === '') {
                echo json_encode(['error' => true, 'mensaje' => 'Complete nombre, email y contraseña.']);
                exit;
            }

          
            $pdo->beginTransaction();
            try {
               
                $sqlUser = "INSERT INTO Usuarios (nombre, email, contrasena, fecha_creacion, id_rol)
                            OUTPUT INSERTED.id
                            VALUES (?, ?, ?, GETDATE(), ?)";
                $stmt = $pdo->prepare($sqlUser);
                $stmt->execute([$usuario_nombre, $email, $contrasena, $id_rol]);
                $id_usuario = $stmt->fetchColumn();

             
                if ($emp_nombre !== '' || $emp_apellido !== '') {
                    $sqlEmp = "INSERT INTO Empleados (nombre, apellido, cuit, id_sucursal, telefono, id_turno, fecha_alta, fecha_baja, sueldo, id_cargo, id_usuario)
                               VALUES (?, ?, ?, ?, ?, NULL, ?, NULL, ?, NULL, ?)";
                    $stmt2 = $pdo->prepare($sqlEmp);
                    $stmt2->execute([$emp_nombre, $emp_apellido, $cuit, $id_sucursal, $telefono, $fecha_alta, $sueldo, $id_usuario]);
                }

                $pdo->commit();
                echo json_encode(['error' => false, 'mensaje' => 'Usuario creado correctamente']);
            } catch (Exception $e) {
                $pdo->rollBack();
                echo json_encode(['error' => true, 'mensaje' => 'Error al crear. ' . $e->getMessage()]);
            }

            break;

        case 'editar':
            $id_usuario = intval($_POST['id_usuario'] ?? 0);
            if (!$id_usuario) {
                echo json_encode(['error' => true, 'mensaje' => 'ID inválido']);
                exit;
            }

          
            $usuario_nombre = trim($_POST['usuario_nombre'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $id_rol = intval($_POST['id_rol'] ?? 0);
            $contrasena = trim($_POST['contrasena'] ?? ''); 

           
            $id_empleado = $_POST['id_empleado'] === '' ? null : intval($_POST['id_empleado']);
            $emp_nombre = trim($_POST['emp_nombre'] ?? '');
            $emp_apellido = trim($_POST['emp_apellido'] ?? '');
            $telefono = trim($_POST['telefono'] ?? null);
            $cuit = trim($_POST['cuit'] ?? null);
            $id_sucursal = $_POST['id_sucursal'] === '' ? null : intval($_POST['id_sucursal']);
            $sueldo = $_POST['sueldo'] === '' ? null : intval($_POST['sueldo']);
            $fecha_alta = $_POST['fecha_alta'] ?? null;

            $pdo->beginTransaction();
            try {
                
                if ($contrasena !== '') {
                    $sql = "UPDATE Usuarios SET nombre=?, email=?, contrasena=?, id_rol=? WHERE id=?";
                    $pdo->prepare($sql)->execute([$usuario_nombre, $email, $contrasena, $id_rol, $id_usuario]);
                } else {
                    $sql = "UPDATE Usuarios SET nombre=?, email=?, id_rol=? WHERE id=?";
                    $pdo->prepare($sql)->execute([$usuario_nombre, $email, $id_rol, $id_usuario]);
                }

                
                if ($id_empleado) {
                    $sqlE = "UPDATE Empleados SET nombre=?, apellido=?, cuit=?, id_sucursal=?, telefono=?, fecha_alta=?, sueldo=? WHERE id=?";
                    $pdo->prepare($sqlE)->execute([$emp_nombre, $emp_apellido, $cuit, $id_sucursal, $telefono, $fecha_alta, $sueldo, $id_empleado]);
                } else {
                    
                    if ($emp_nombre !== '' || $emp_apellido !== '') {
                        $sqlInsertE = "INSERT INTO Empleados (nombre, apellido, cuit, id_sucursal, telefono, id_turno, fecha_alta, fecha_baja, sueldo, id_cargo, id_usuario)
                                       VALUES (?, ?, ?, ?, ?, NULL, ?, NULL, ?, NULL, ?)";
                        $pdo->prepare($sqlInsertE)->execute([$emp_nombre, $emp_apellido, $cuit, $id_sucursal, $telefono, $fecha_alta, $sueldo, $id_usuario]);
                    }
                }

                $pdo->commit();
                echo json_encode(['error' => false, 'mensaje' => 'Actualizado correctamente']);
            } catch (Exception $e) {
                $pdo->rollBack();
                echo json_encode(['error' => true, 'mensaje' => 'Error al actualizar: ' . $e->getMessage()]);
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
                
                $pdo->prepare("DELETE FROM Empleados WHERE id_usuario = ?")->execute([$id_usuario]);
                
                $pdo->prepare("DELETE FROM Usuarios WHERE id = ?")->execute([$id_usuario]);

                $pdo->commit();
                echo json_encode(['error' => false, 'mensaje' => 'Eliminado correctamente']);
            } catch (Exception $e) {
                $pdo->rollBack();
                echo json_encode(['error' => true, 'mensaje' => 'Error al eliminar: ' . $e->getMessage()]);
            }
            break;

        default:
            echo json_encode(['error' => true, 'mensaje' => 'Acción no definida']);
            break;
    }
} catch (Exception $e) {
    echo json_encode(['error' => true, 'mensaje' => $e->getMessage()]);
}