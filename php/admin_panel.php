<?php
    require_once 'funciones/deteccion_session.php';
    // Se asume que este archivo solo debe ser accesible por roles con permisos de administración
    include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    
    <link rel="stylesheet" href="../css/navbar_emp.css">
    <link rel="stylesheet" href="../css/admin_panel.css"> 
    
    <script src="../js/adminUsuarios.js"></script>
</head>

<body onload="listarUsuarios()">
    <?php
        require_once 'funciones/def_navbar.php';
    ?>

    <main class="admin-container">
        <h1>Administración de Usuarios y Empleados</h1>
        
        <button id="btnNuevo" class="btn btn-agregar">➕ Nuevo Usuario/Empleado</button>

        <div class="table-responsive">
            <table id="tablaUsuarios" class="tabla-usuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre Usuario</th>
                        <th>Email</th>
                        <th>Rol ID</th>
                        <th>Nombre Empleado</th>
                        <th>CUIT</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    </tbody>
            </table>
        </div>
        
        <div id="formulario" class="modal-form" style="display: none;">
            <div class="modal-content">
                <h2 id="tituloForm">Nuevo Usuario</h2>
                <form id="formUsuario">
                    <input type="hidden" id="idUsuario" name="id">

                    <div class="form-group">
                        <label for="nombre">Nombre de Usuario:</label>
                        <input type="text" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="contrasena">Contraseña (Solo si es nuevo o para cambiar):</label>
                        <input type="password" id="contrasena" name="contrasena">
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol (ID):</label>
                        <select id="rol" name="id_rol" required>
                            <option value="1">1 - Administrador</option>
                            <option value="2">2 - Empleado</option>
                            <option value="3">3 - Gerente</option>
                            <option value="4">4 - Cliente</option>
                        </select>
                    </div>

                    <div id="empleado-fields">
                        <h3 class="employee-title">Datos de Empleado (Si aplica)</h3>
                        <div class="form-group">
                            <label for="emp_nombre">Nombre Empleado:</label>
                            <input type="text" id="emp_nombre" name="emp_nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido Empleado:</label>
                            <input type="text" id="apellido" name="apellido">
                        </div>
                        <div class="form-group">
                            <label for="cuit">CUIT:</label>
                            <input type="text" id="cuit" name="cuit">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" id="telefono" name="telefono">
                        </div>
                         <div class="form-group">
                            <label for="sueldo">Sueldo:</label>
                            <input type="number" step="0.01" id="sueldo" name="sueldo">
                        </div>
                        <div class="form-group">
                            <label for="id_sucursal">Sucursal (ID):</label>
                            <input type="number" id="id_sucursal" name="id_sucursal">
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" id="btnGuardar" class="btn btn-guardar">Guardar</button>
                        <button type="button" id="btnCancelar" class="btn btn-cancelar">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
