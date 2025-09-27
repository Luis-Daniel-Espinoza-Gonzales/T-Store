<?php
session_start();
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="../css/reporte.css">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
</head>

<body>
  <?php require_once 'funciones/def_navbar.php'; ?>

  <form id="form">
  <div class="field">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="<?php echo $_SESSION['name']; ?>" readonly>
  </div>
  <div class="field">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?php echo $_SESSION['email']; ?>" readonly>
  </div>
  <div class="field">
    <label for="Area">Área</label>
    <select name="Area" id="Area" required>
      <option value="">Seleccione el área afectada</option>
      <option value="Logística">Logística</option>
      <option value="Producción">Inventario</option>
      <option value="Ventas">Ventas</option>
      <option value="Administración">Administración</option>
    </select>
  </div>
  <div class="field">
    <label for="error">Error</label>
    <select name="error" id="error" required>
      <option value="">Seleccione el tipo de error</option>
      <option value="Falla en el sistema">Falla en el sistema</option>
      <option value="Dato incorrecto">Dato incorrecto</option>
      <option value="Demora en proceso">Demora en proceso</option>
      <option value="XD">XD</option>
      <option value="Otro">Otro</option>
    </select>
  </div>
  <div class="field">
    <label for="descripcion">Descripción</label>
    <input type="text" name="descripcion" id="descripcion" required>
  </div>

  <input type="submit" id="button" value="Enviar Reporte">
  <p class="warning-text">El uso indebido del reporte será sancionado.</p>
</form>


  <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
  <script>
    emailjs.init('7Qy9EvCWb5sLoRxNM'); 
  </script>
  <script src="../js/reporte.js"></script>
</body>
</html>
