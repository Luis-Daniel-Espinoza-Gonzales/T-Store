<?php
require_once '../env.php';

session_reset();
session_start();

switch($_POST['comprobar']){
    
    case 'ingresar':
        $ingresar = ["error" => 0];
        $user = $_POST['usuario'];
        $pass = $_POST['password'];

        $comprobar_usuario = "SELECT * FROM Usuarios WHERE nombre = '$user'";

        $stmt_usuario = sqlsrv_prepare($conexion, $comprobar_usuario);

        if(sqlsrv_execute($stmt_usuario) === false){
            echo "error";
            print_r(sqlsrv_errors());
            die();
        }

        if(!sqlsrv_fetch($stmt_usuario)){
            $ingresar['error'] = "1";
            echo json_encode($ingresar);
            die();
        }
        

        $comprobar_contraseña = "SELECT * FROM Usuarios WHERE nombre = '$user' AND contrasena = '$pass'";

        $stmt_contraseña = sqlsrv_prepare($conexion, $comprobar_contraseña);
        
        if(sqlsrv_execute($stmt_contraseña) === false){
            echo "error";
            print_r(sqlsrv_errors());
            die();
        }

        if(!sqlsrv_fetch($stmt_contraseña)){
            $ingresar['error'] = "2";
            echo json_encode($ingresar);
            die();
        }
        else{
            $ingresar['error'] = "0";
            
            $comprobar_rol = "SELECT id_rol FROM Usuarios WHERE nombre = '$user'";

            $stmt_rol = sqlsrv_query($conexion, $comprobar_rol);
            sqlsrv_fetch($stmt_rol);

            $rol = sqlsrv_get_field($stmt_rol, 0);

            if($rol == 4){
                //cliente

                $datos = "SELECT Usuarios.id_rol AS rol, Usuarios.nombre AS nombre_usuario, Usuarios.email, Clientes.nombre, Clientes.apellido, Clientes.dni, Clientes.telefono FROM Usuarios
                INNER JOIN Clientes ON Usuarios.id = Clientes.id_usuario
                WHERE Usuarios.nombre = '$user'";

                $stmt_datos = sqlsrv_prepare($conexion, $datos);
                if(sqlsrv_execute($stmt_datos) === false){
                    echo "error";
                    print_r(sqlsrv_errors());
                    die();
                }

                $row = sqlsrv_fetch_array($stmt_datos, SQLSRV_FETCH_ASSOC);

                $role = $row['rol'];
                $username = $row['nombre_usuario'];
                $email = $row['email'];
                $name = $row['nombre'];
                $lastname = $row['apellido'];
                $dni = $row['dni'];
                $telefono = $row['telefono'];

                $_SESSION['rol'] = $role;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['dni'] = $dni;
                $_SESSION['telefono'] = $telefono;

            } 
            else {
                //empleado
                $datos = "SELECT Usuarios.id_rol AS rol, Usuarios.nombre AS nombre_usuario, Usuarios.email, Empleados.nombre, Empleados.apellido, Empleados.cuit, Sucursales.nombre AS sucursal, Empleados.fecha_alta, Cargos.nombre AS cargo FROM Usuarios
                INNER JOIN Empleados ON Usuarios.id = Empleados.id_usuario
                INNER JOIN Cargos ON Empleados.id_cargo = Cargos.id
                INNER JOIN Sucursales ON Empleados.id_sucursal = Sucursales.id
                WHERE Usuarios.nombre = '$user'";

                $stmt_datos = sqlsrv_prepare($conexion, $datos);
                if(sqlsrv_execute($stmt_datos) === false){
                    echo "error";
                    print_r(sqlsrv_errors());
                    die();
                }

                $row = sqlsrv_fetch_array($stmt_datos, SQLSRV_FETCH_ASSOC);

                $role = $row['rol'];
                $username = $row['nombre_usuario'];
                $email = $row['email'];
                $name = $row['nombre'];
                $lastname = $row['apellido'];
                $cuit = $row['cuit'];
                $sucursal = $row['sucursal'];
                $fecha_alta = $row['fecha_alta'];
                $alta = $fecha_alta -> format ('Y-m-d');
                $cargo = $row['cargo'];

                $_SESSION['rol'] = $role;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['name'] = $name;
                $_SESSION['lastname'] = $lastname;
                $_SESSION['cuit'] = $cuit;
                $_SESSION['sucursal'] = $sucursal;
                $_SESSION['fecha_alta'] = $alta;
                $_SESSION['cargo'] = $cargo;

            }
        }
        ob_end_clean();
        echo json_encode($ingresar);
        break;

    case 'extraer':
        echo json_encode($_SESSION);
        break;
    
    case 'cerrar':
        session_destroy();
        echo json_encode("nan");
        break;
}

?>