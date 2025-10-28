<?php

session_start();

?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel Administración - Usuarios & Empleados</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <style>
    body { padding: 20px; background: #f5f7fb; }
    .card { border-radius: 12px; box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06); }
    .modal .form-label { font-weight: 600; }
    .table thead { background: linear-gradient(90deg,#1e3a8a,#2563eb); color:white; }
    .btn-brand { background: linear-gradient(90deg,#2563eb,#06b6d4); color: #fff; border: none; }
  </style>
</head>
<body>

<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Panel de Administración — Usuarios & Empleados</h2>
    <div>
      <button id="btnNuevo" class="btn btn-brand">➕ Nuevo</button>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table id="tabla" class="table table-hover table-bordered align-middle">
          <thead>
            <tr>
              <th>ID Usuario</th>
              <th>Nombre Usuario</th>
              <th>Email</th>
              <th>Rol</th>
              <th>Nombre Empleado</th>
              <th>Apellido</th>
              <th>Teléfono</th>
              <th>Sucursal</th>
              <th>CUIT</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="cuerpoTabla">
           
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formRegistro">
        <div class="modal-header">
          <h5 class="modal-title" id="tituloModal">Nuevo Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_usuario" name="id_usuario">
          <input type="hidden" id="id_empleado" name="id_empleado">

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre de usuario</label>
              <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Contraseña <small class="text-muted">(solo si la quiere cambiar)</small></label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Dejar vacío para no cambiar">
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol (id_rol)</label>
              <input type="number" class="form-control" id="id_rol" name="id_rol" value="1">
            </div>

            <hr class="my-2">

            <div class="col-md-4">
              <label class="form-label">Nombre (empleado)</label>
              <input type="text" class="form-control" id="emp_nombre" name="emp_nombre">
            </div>
            <div class="col-md-4">
              <label class="form-label">Apellido</label>
              <input type="text" class="form-control" id="emp_apellido" name="emp_apellido">
            </div>
            <div class="col-md-4">
              <label class="form-label">Teléfono</label>
              <input type="text" class="form-control" id="telefono" name="telefono">
            </div>
            <div class="col-md-4">
              <label class="form-label">Sucursal (id)</label>
              <input type="number" class="form-control" id="id_sucursal" name="id_sucursal">
            </div>
            <div class="col-md-4">
              <label class="form-label">CUIT</label>
              <input type="text" class="form-control" id="cuit" name="cuit">
            </div>
            <div class="col-md-4">
              <label class="form-label">Sueldo</label>
              <input type="number" class="form-control" id="sueldo" name="sueldo">
            </div>
            <div class="col-md-6">
              <label class="form-label">Fecha alta</label>
              <input type="date" class="form-control" id="fecha_alta" name="fecha_alta">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-brand">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const apiUrl = 'Funciones/usuarios_api.php';

$(function(){
 
  listar();


  $('#btnNuevo').click(function(){
    limpiarForm();
    $('#tituloModal').text('Nuevo Usuario & Empleado');
    let modal = new bootstrap.Modal(document.getElementById('modalForm'));
    modal.show();
  });

 
  $('#formRegistro').on('submit', function(e){
    e.preventDefault();
    let formData = $(this).serializeArray();
   
    let accion = $('#id_usuario').val() ? 'editar' : 'crear';
    formData.push({ name: 'accion', value: accion});

    $.post(apiUrl, formData, function(res){
      if (res.error === false || res.error === undefined) {
        Swal.fire({ icon: 'success', title: 'Listo', text: res.mensaje || 'Operación correcta', timer: 1500, showConfirmButton: false });
        $('#modalForm').modal && $('#modalForm').modal('hide');
        listar();
      } else {
        Swal.fire({ icon: 'error', title: 'Error', text: res.mensaje || 'Hubo un problema' });
      }
    }, 'json').fail(function(xhr){
      Swal.fire({ icon: 'error', title: 'Error', text: 'Error de servidor: '+xhr.statusText });
    });
  });
});

function listar(){
  $.post(apiUrl, { accion: 'listar' }, function(data){
    let html = '';
    data.forEach(function(r){
      html += `<tr>
        <td>${escapeHtml(r.id_usuario ?? '')}</td>
        <td>${escapeHtml(r.usuario_nombre ?? '')}</td>
        <td>${escapeHtml(r.email ?? '')}</td>
        <td>${escapeHtml(r.id_rol ?? '')}</td>
        <td>${escapeHtml(r.emp_nombre ?? '')}</td>
        <td>${escapeHtml(r.emp_apellido ?? '')}</td>
        <td>${escapeHtml(r.telefono ?? '')}</td>
        <td>${escapeHtml(r.id_sucursal ?? '')}</td>
        <td>${escapeHtml(r.cuit ?? '')}</td>
        <td>
          <button class="btn btn-sm btn-outline-primary" onclick="editar(${r.id_usuario})">✏️</button>
          <button class="btn btn-sm btn-outline-danger" onclick="eliminar(${r.id_usuario})">🗑️</button>
        </td>
      </tr>`;
    });
    $('#cuerpoTabla').html(html);
  }, 'json');
}

function editar(id){
  $.post(apiUrl, { accion: 'obtener', id: id }, function(r){
    if (!r) { Swal.fire('Error','No se encontró registro','error'); return; }
    
    $('#id_usuario').val(r.id_usuario);
    $('#usuario_nombre').val(r.usuario_nombre);
    $('#email').val(r.email);
    $('#id_rol').val(r.id_rol);
    $('#contrasena').val(''); 
    $('#id_empleado').val(r.id_empleado ?? '');
    $('#emp_nombre').val(r.emp_nombre ?? '');
    $('#emp_apellido').val(r.emp_apellido ?? '');
    $('#telefono').val(r.telefono ?? '');
    $('#id_sucursal').val(r.id_sucursal ?? '');
    $('#cuit').val(r.cuit ?? '');
    $('#sueldo').val(r.sueldo ?? '');
    $('#fecha_alta').val(r.fecha_alta ? r.fecha_alta.split(' ')[0] : '');

    $('#tituloModal').text('Editar Usuario & Empleado');
    let modal = new bootstrap.Modal(document.getElementById('modalForm'));
    modal.show();
  }, 'json');
}

function eliminar(id){
  Swal.fire({
    title: '¿Eliminar?',
    text: "Esta acción eliminará el usuario y su empleado relacionado.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      $.post(apiUrl, { accion: 'eliminar', id: id }, function(res){
        if (res.error === false || res.error === undefined) {
          Swal.fire('Eliminado','Registro eliminado correctamente','success');
          listar();
        } else {
          Swal.fire('Error', res.mensaje || 'No se pudo eliminar','error');
        }
      }, 'json');
    }
  });
}

function limpiarForm(){
  $('#formRegistro')[0].reset();
  $('#id_usuario').val('');
  $('#id_empleado').val('');
  $('#contrasena').val('');
}


function escapeHtml(text) {
  if (!text && text !== 0) return '';
  return String(text)
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
</script>

</body>
</html>