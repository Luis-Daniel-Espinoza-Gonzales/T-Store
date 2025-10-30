$(document).ready(function(){
    listarUsuarios();

    $("#btnNuevo").click(function(){
        $("#formulario").show();
        $("#tituloForm").text("Nuevo Usuario");
        $("#idUsuario").val("");
    });

    $("#btnCancelar").click(function(){
        $("#formulario").hide();
    });

    $("#btnGuardar").click(function(){
        let id = $("#idUsuario").val();
        let datos = {
            accion: id ? "editar" : "crear",
            id: id,
            nombre: $("#nombre").val(),
            email: $("#email").val(),
            contrasena: $("#contrasena").val(),
            id_rol: $("#rol").val(),
            empleado: $("#empleado").val()
        };

        $.post("Funciones/usuarios.php", datos, function(res){
            alert(res.mensaje);
            $("#formulario").hide();
            listarUsuarios();
        }, "json");
    });
});

function listarUsuarios(){
    $.post("Funciones/usuarios.php", {accion: "listar"}, function(data){
        let tbody = "";
        data.forEach(function(u){
            tbody += `
                <tr>
                    <td>${u.id}</td>
                    <td>${u.nombre}</td>
                    <td>${u.email}</td>
                    <td>${u.id_rol}</td>
                    <td>${u.empleado || "-"}</td>
                    <td>
                        <button onclick="editarUsuario(${u.id})">✏️</button>
                        <button onclick="eliminarUsuario(${u.id})">🗑️</button>
                    </td>
                </tr>`;
        });
        $("#tablaUsuarios tbody").html(tbody);
    }, "json");
}

function editarUsuario(id){
    $.post("Funciones/usuarios.php", {accion:"obtener", id:id}, function(data){
        $("#formulario").show();
        $("#tituloForm").text("Editar Usuario");
        $("#idUsuario").val(data.id);
        $("#nombre").val(data.nombre);
        $("#email").val(data.email);
        $("#rol").val(data.id_rol);
    }, "json");
}

function eliminarUsuario(id){
    if(confirm("¿Seguro que desea eliminar este usuario?")){
        $.post("Funciones/usuarios.php", {accion:"eliminar", id:id}, function(res){
            alert(res.mensaje);
            listarUsuarios();
        }, "json");
    }
}