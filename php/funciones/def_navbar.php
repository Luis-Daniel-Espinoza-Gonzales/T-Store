<?php
    if ($_SESSION['rol'] == 4) {
        include('navbar_cli.php');
    } else {
        include('navbar_emp.php');
    }
?>