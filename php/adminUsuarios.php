<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Usuarios y Empleados</title>
    <link rel="stylesheet" href="estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="adminUsuarios.js"></script>
</head>
<body>
    <h1>Panel de Administración</h1>

    <button id="btnNuevo">➕ Nuevo Usuario/Empleado</button>

    <table border="1" id="tablaUsuarios">
        <thead>
            <tr>
                <th>ID Usuario</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Empleado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>

    
    <div id="formulario" style="display:none;">
        <h2 id="tituloForm">Nuevo Usuario</h2>
        <input type="hidden" id="idUsuario">
        <label>Nombre:</label> <input type="text" id="nombre"><br>
        <label>Email:</label> <input type="text" id="email"><br>
        <label>Contraseña:</label> <input type="password" id="contrasena"><br>
        <label>Rol (id_rol):</label> <input type="number" id="rol"><br>
        <label>Empleado asociado:</label> <input type="text" id="empleado"><br>
        <button id="btnGuardar">Guardar</button>
        <button id="btnCancelar">Cancelar</button>
    </div>

</body>
</html>