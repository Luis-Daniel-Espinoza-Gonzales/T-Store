<?php
session_start();
unset($_SESSION);
unset($_COOKIE);
session_unset();
session_destroy();
header("Location: ../login.php"); 
exit();
?>