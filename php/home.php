
<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['name'])) {
    // Si no ha iniciado sesión, redirige a login.php
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
    <link rel="stylesheet" type="text/css" href="..css/homestyle.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

</head>

<body>
    <?php
        include "navbar.php";
    ?>

    <h1><u>TechGenius Distribution S.A</u></h1>
    <h4><u><i>(¿Que hace la empresa?)</i></u></h5>
        <img src="../images/Elogo.png" alt="" width="550" height="550" class="logo">
        <div class="information">

            <p id = ftext>
                Nuestra empresa se dedica por completo a ofrecer productos electrónicos de alta calidad,
                ventas con pasión, conocimiento y un servicio técnico excepcional. Nos esforzamos por superar
                las expectativas de nuestros clientes en cada interacción, demostrando nuestro compromiso con
                la excelencia en todo lo que hacemos. Esta empresa estaría dirigida a clientes que valoran la
                calidad, la confiabilidad y el servicio al cliente excepcional en el ámbito de los productos y
                componentes electrónicos.
            </p>

        </div>
        <div class="contenedor">
        <p class = "objetivos">Nuestros objetivos como empresa distribuidora de componentes, Hardware y ofrecimiento de servicio técnico consiste en:
            Brindar productos de hardware de alta calidad y confiabilidad a los clientes en nuestras sucursales ubicadas en CABA, además
            ofrecemos un servicio técnico rápido y eficiente para solucionar los problemas de hardware de los clientes.Dentro del área interna
            nosotros queremos optimizar los procesos de las distintas áreas que conforman nuestra empresa para mejorar la eficiencia y reducir
            los costos operativos, también nos centramos en establecer alianzas estratégicas con fabricantes y proveedores para garantizar
            la disponibilidad y calidad de los productos. Asimismo queremos desarrollar una sólida reputación en el mercado como una empresa
            confiable y experta en hardware y servicios técnicos incluso alcanzar un crecimiento sostenible, exponencial y rentable en el
            mercado de la tecnología.
        </p>
    </div>

</body>
<script>
    var user = document.getElementById('usericon');
    document.getElementById('pfp').addEventListener('mouseover', on);
    document.getElementById('pfp').addEventListener('mouseout', out);

    function on() {
        user.style.right = "370px";
        user.style.filter = "invert(100)"
    }

    function out() {

        user.style.right = "380px";
        user.style.filter = "invert(0)"
    }
    document.getElementById('notp').addEventListener('mouseover', ses);
    document.getElementById('notp').addEventListener('mouseout', nel);

    function ses() {
        user.style.right = "370px";
        
    }

    function nel() {

        user.style.right = "380px";
   
    }

    document.getElementById('notp2').addEventListener('mouseover', ses);
    document.getElementById('notp2').addEventListener('mouseout', nel);

    function ses() {
        user.style.right = "370px";
        
    }

    function nel() {

        user.style.right = "380px";
   
    }
</script>

</html>