<?php
include 'conexion.php';

// ----- CREAR -----
if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['id_rol'];

    // Insertar en Usuarios
    $sqlUsuario = "INSERT INTO Usuarios (nombre, email, contrasena, fecha_creacion, id_rol) 
                   VALUES (?, ?, ?, GETDATE(), ?)";
    $paramsUsuario = array($nombre, $email, $contrasena, $rol);

    if (sqlsrv_query($conexion, $sqlUsuario, $paramsUsuario)) {
        echo "<p style='color:green;'>✅ Usuario creado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al crear usuario.</p>";
        die(print_r(sqlsrv_errors(), true));
    }
}

// ----- EDITAR -----
if (isset($_POST['editar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $rol = $_POST['id_rol'];

    $sql = "UPDATE Usuarios SET nombre = ?, email = ?, id_rol = ? WHERE id = ?";
    $params = array($nombre, $email, $rol, $id);
    if (sqlsrv_query($conexion, $sql, $params)) {
        echo "<p style='color:green;'>✏️ Usuario actualizado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al actualizar.</p>";
    }
}

// ----- ELIMINAR -----
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $sql = "DELETE FROM Usuarios WHERE id = ?";
    $params = array($id);
    if (sqlsrv_query($conexion, $sql, $params)) {
        echo "<p style='color:green;'>🗑️ Usuario eliminado correctamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error al eliminar.</p>";
    }
}

// ----- OBTENER USUARIOS -----
$sql = "SELECT * FROM Usuarios";
$stmt = sqlsrv_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <style>
        body {
            background: #fafafa;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 { text-align: center; color: #333; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th { background-color: #0078D7; color: white; }
        form {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            width: 50%;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input, select {
            margin: 5px;
            padding: 8px;
            width: 90%;
        }
        input[type="submit"] {
            background-color: #0078D7;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover { background-color: #005a9e; }
        a {
            color: red;
            text-decoration: none;
        }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Panel de Administración de Usuarios 👥</h1>

    <!-- Formulario de creación -->
    <form method="POST">
        <h3>Agregar nuevo usuario</h3>
        <input type="text" name="nombre" placeholder="Nombre de usuario" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br>
        <label for="id_rol">Rol:</label><br>
        <select name="id_rol" required>
            <option value="1">Administrador</option>
            <option value="2">Empleado</option>
            <option value="3">Gerente</option>
            <option value="4">Cliente</option>
        </select><br>
        <input type="submit" name="crear" value="Crear usuario">
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Fecha de creación</th>
            <th>Acciones</th>
        </tr>

        <?php while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) { ?>
            <tr>
                <form method="POST">
                    <td><?php echo $row['id']; ?></td>
                    <td><input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"></td>
                    <td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td>
                    <td>
                        <select name="id_rol">
                            <option value="1" <?php if($row['id_rol']==1) echo 'selected'; ?>>Administrador</option>
                            <option value="2" <?php if($row['id_rol']==2) echo 'selected'; ?>>Empleado</option>
                            <option value="3" <?php if($row['id_rol']==3) echo 'selected'; ?>>Gerente</option>
                            <option value="4" <?php if($row['id_rol']==4) echo 'selected'; ?>>Cliente</option>
                        </select>
                    </td>
                    <td>
                        <?php 
                        if ($row['fecha_creacion'] instanceof DateTime) {
                            echo $row['fecha_creacion']->format('Y-m-d H:i:s');
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit" name="editar" value="Guardar cambios">
                        <a href="?eliminar=<?php echo $row['id']; ?>">Eliminar</a>
                    </td>
                </form>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
