// Archivo: ../js/adminUsuarios.js

$(document).ready(function(){
    listarUsuarios(); // Inicializar la tabla al cargar la página

    // Mostrar el formulario para NUEVO usuario
    $("#btnNuevo").click(function(){
        resetearFormulario();
        $("#tituloForm").text("Nuevo Usuario");
        $("#formulario").show();
    });

    // Evento para cambiar visibilidad de campos de empleado al cambiar el rol
    $("#rol").change(function() {
        mostrarOcultarCamposEmpleado(parseInt($(this).val()));
    });
    
    // Ocultar el formulario
    $("#btnCancelar").click(function(){
        $("#formulario").hide();
    });

    // Guardar (Crear o Editar) usuario
    $("#btnGuardar").click(function() {
        guardarUsuario();
    });
});

// Función para mostrar/ocultar campos de empleado
function mostrarOcultarCamposEmpleado(rolId) {
    // Asumiendo que el rol '4' es Cliente y los demás (1, 2, 3) son Empleados/Admin/Gerente
    const esEmpleado = rolId !== 4; 
    const fields = $("#empleado-fields");
    
    if (esEmpleado) {
        fields.show();
        // Hacer requeridos los campos mínimos de empleado para roles de empleado
        $("#emp_nombre").prop('required', true);
        $("#apellido").prop('required', true);
        $("#cuit").prop('required', true);
    } else {
        fields.hide();
        // Remover el atributo required para roles que no son empleado
        $("#emp_nombre").prop('required', false);
        $("#apellido").prop('required', false);
        $("#cuit").prop('required', false);
    }
}


function resetearFormulario() {
    $("#formUsuario")[0].reset();
    $("#idUsuario").val("");
    $("#contrasena").val(""); 
    $("#contrasena").prop('required', true); // Contraseña requerida para NUEVO
    mostrarOcultarCamposEmpleado(4); // Ocultar campos de empleado al resetear
}

function guardarUsuario(){
    let id = $("#idUsuario").val();
    let contrasena = $("#contrasena").val();
    let id_rol = parseInt($("#rol").val());
    
    // Validaciones básicas de campos requeridos de empleado
    if (id_rol !== 4 && (!$("#emp_nombre").val() || !$("#apellido").val() || !$("#cuit").val())) {
         alert("Por favor, complete los campos obligatorios del Empleado (Nombre, Apellido, CUIT).");
         return;
    }

    // Contraseña obligatoria para NUEVOS usuarios
    if (!id && !contrasena) {
        alert("La contraseña es obligatoria para un nuevo usuario.");
        return;
    }
    
    let datos = {
        accion: id ? "editar" : "crear",
        id: id,
        nombre: $("#nombre").val(),
        email: $("#email").val(),
        id_rol: id_rol,
        
        // Solo enviar la contraseña si se está creando o si se editó
        ...(contrasena && { contrasena: contrasena }), 
        
        // Datos de Empleado (se envían aunque estén vacíos si es cliente, 
        // la API de PHP sabrá ignorarlos)
        emp_nombre: $("#emp_nombre").val(),
        apellido: $("#apellido").val(),
        cuit: $("#cuit").val(),
        telefono: $("#telefono").val(),
        sueldo: $("#sueldo").val(),
        id_sucursal: $("#id_sucursal").val()
    };
    
    // NOTA: Endpoint corregido a 'funciones/usuarios_api.php'
    $.post("funciones/usuarios_api.php", datos, function(res){
        if(res.error) {
            alert("Error: " + res.mensaje);
        } else {
            alert(res.mensaje);
            $("#formulario").hide();
            listarUsuarios();
        }
    }, "json").fail(function(jqXHR, textStatus, errorThrown) {
        alert("Error al comunicarse con el servidor (Guardar). Revise la consola.");
        console.error(jqXHR.responseText);
    });
}

function listarUsuarios(){
    // NOTA: Endpoint corregido a 'funciones/usuarios_api.php'
    $.post("funciones/usuarios_api.php", {accion: "listar"}, function(data){
        let tbody = "";
        data.forEach(function(u){
            const nombreEmpleado = u.emp_nombre || u.emp_apellido ? `${u.emp_nombre || ''} ${u.emp_apellido || ''}`.trim() : '-';
            
            tbody += `
                <tr>
                    <td>${u.id_usuario}</td>
                    <td>${u.usuario_nombre}</td>
                    <td>${u.email}</td>
                    <td>${u.id_rol}</td>
                    <td>${nombreEmpleado}</td>
                    <td>${u.cuit || '-'}</td>
                    <td>
                        <button class="btn-accion btn-editar" onclick="editarUsuario(${u.id_usuario})">✏️ Editar</button>
                        <button class="btn-accion btn-eliminar" onclick="eliminarUsuario(${u.id_usuario})">🗑️ Eliminar</button>
                    </td>
                </tr>`;
        });
        $("#tablaUsuarios tbody").html(tbody);
    }, "json").fail(function(jqXHR, textStatus, errorThrown) {
        $("#tablaUsuarios tbody").html('<tr><td colspan="7">Error al cargar usuarios. Revise la consola.</td></tr>');
        console.error("Error en listarUsuarios:", jqXHR.responseText);
    });
}

function editarUsuario(id){
    resetearFormulario();
    $("#contrasena").prop('required', false); // Contraseña opcional al EDITAR
    
    // Obtener datos del usuario/empleado por ID
    // NOTA: Endpoint corregido a 'funciones/usuarios_api.php'
    $.post("funciones/usuarios_api.php", {accion:"obtener", id:id}, function(data){
        if (data.error) {
             alert(data.mensaje);
             return;
        }

        $("#formulario").show();
        $("#tituloForm").text("Editar Usuario");
        
        // Rellenar campos de Usuario
        $("#idUsuario").val(data.id);
        $("#nombre").val(data.nombre);
        $("#email").val(data.email);
        $("#rol").val(data.id_rol);
        
        // Rellenar campos de Empleado
        mostrarOcultarCamposEmpleado(data.id_rol);
        $("#emp_nombre").val(data.emp_nombre || '');
        $("#apellido").val(data.apellido || '');
        $("#cuit").val(data.cuit || '');
        $("#telefono").val(data.telefono || '');
        $("#sueldo").val(data.sueldo || '');
        $("#id_sucursal").val(data.id_sucursal || '');
        
    }, "json").fail(function(jqXHR, textStatus, errorThrown) {
        alert("Error al obtener datos para edición.");
    });
}

function eliminarUsuario(id){
    if(confirm("¿Seguro que desea eliminar este usuario y sus datos de empleado asociados? Esta acción es irreversible.")){
        // NOTA: Endpoint corregido a 'funciones/usuarios_api.php'
        $.post("funciones/usuarios_api.php", {accion:"eliminar", id:id}, function(res){
            if(res.error) {
                alert("Error al eliminar: " + res.mensaje);
            } else {
                alert(res.mensaje);
                listarUsuarios();
            }
        }, "json").fail(function(jqXHR, textStatus, errorThrown) {
            alert("Error al comunicarse con el servidor para eliminar.");
        });
    }
}