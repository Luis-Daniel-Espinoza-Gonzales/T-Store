<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js/login.js"></script>
</head>

<body>
    <div id="content_01">
        <div id="content_02">
            <h2>Inicio de sesión</h2>
            <form action="">
                <div id="content_03">
                    <div id="content_04">
                        <div class="content_04">
                            <label for="name">
                                <h4>Nombre de usuario:</h4>
                            </label>
                            <input placeholder="User" type="text" id="user" name="user" required>
                        </div>
                    </div>
                    <div id="content_04">
                        <div class="content_04">
                            <label for="password">
                                <h4>Contraseña:</h4>
                            </label>
                            <input placeholder="Contraseña" type="password" id="pass" name="password" required>
                        </div>
                    </div>
                    <div id="content_button">
                        <div id="none"></div>
                        <input type="button" id="button_00" onclick="
                            ingreso(
                                document.getElementById('user').value,
                                document.getElementById('pass').value
                            )" value="Ingresar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>