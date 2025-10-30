<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/navbar_emp.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    <header>

        <nav>
            <ul>
                <li class="title"><a href="home.php">TechGenius Distribution S.A</a></li>
                <li><a id="notp" href="ventas.php">Ventas</a></li>
                <li><a id="notp" href="productos.php">Productos</a></li>
                <li><a id="notp2" href="logistica.php">Logistica</a></li>
                <li><a id="notp2" href="stock_sucursal.php">Inventario</a></li>
                <li><a id="notp2" href="#">Reportes</a></li>
                <li><a id="notp2" href="administracion.php">Administración</a></li>
            </ul>
            <div class = "iusa_info" id = "infa" >
          <svg id='Back_24' width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><rect width='24' height='24' stroke='none' fill='#000000' opacity='0'/>
<g transform="matrix(0.48 0 0 0.48 12 12)" >
<path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" translate(-25.01, -25)" d="M 34.980469 3.992188 C 34.71875 3.996094 34.472656 4.105469 34.292969 4.292969 L 14.292969 24.292969 C 13.902344 24.683594 13.902344 25.316406 14.292969 25.707031 L 34.292969 45.707031 C 34.542969 45.96875 34.917969 46.074219 35.265625 45.980469 C 35.617188 45.890625 35.890625 45.617188 35.980469 45.265625 C 36.074219 44.917969 35.96875 44.542969 35.707031 44.292969 L 16.414063 25 L 35.707031 5.707031 C 36.003906 5.417969 36.089844 4.980469 35.929688 4.601563 C 35.769531 4.21875 35.394531 3.976563 34.980469 3.992188 Z" stroke-linecap="round" />
</g>
</svg>

                <div id = "pfp"> 
                    <input type = "file" id = "selein" accept = "image/png, image/jpg">
                        <div  id = "display_image"> </div>
                </div>
                    <ul class = "ulemp">
                        <li id = 'dat' class = "emp">Nombre: <?php echo $_SESSION ['name']; ?></li>
                        <li id = 'dat' class = "emp">Apellido: <?php echo $_SESSION ['lastname']; ?></li>
                        <li id = 'dat' class = "emp">cargo: <?php echo $_SESSION ['cargo']; ?></li>
                        <li id = 'dat' class = "emp">fecha de alta: <?php echo $_SESSION ['fecha_alta']; ?></li>
                    </ul>
                    <button id = 'salirahh'>Cerrar sesion</button>
                    
            </div>
        
        <svg id="usericon" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
            <path fill-rule="evenodd" d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z" clip-rule="evenodd" />
        </svg>

    </header>
    <script src = "../js/perfil.js"></script>
    <script src = "../js/pfpchange.js"></script>
     <script src = "../js/cerrar_sesion.js"></script>
   
</body>
</html>