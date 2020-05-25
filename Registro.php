<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php en la carpeta anterior
2. crearTabla.php en la carpeta anterior
-->

<?php
    session_start();

    include_once 'utils.php';

    include_once 'config.php';

    //crear Conexión
    //Variables en archivo config
    $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $error = false;

        if(empty($_POST['NombreUsuario']))
        {
            $_SESSION['errNombreUsuario']="El Nombre de Usuario es obligatorio";
            $error = true;
        }
        else
        {
            $nombreUsuario = limpiar_entrada($_POST['NombreUsuario']);
            $_SESSION['nombreUsuario'] = $nombreUsuario;
            if (!preg_match("/^[a-zA-Z0-9_-]*$/",$nombreUsuario))
            {
                $_SESSION['errNombreUsuario'] = "Solo letras, números, '-' o '_'!";
                $error = true;
            }
            else
            {
                $sql = "SELECT * FROM Usuarios Where NombreUsuario='$nombreUsuario'";
                $resultado = mysqli_query($con, $sql);
                $aux = mysqli_fetch_array($resultado);
                if($aux != null)
                {
                    $_SESSION['errNombreUsuario'] = "Ya existe un Usuario con este nombre!";
                    $error = true;
                }
            }
        }

        if(empty($_POST['Email']))
        {
            $_SESSION['errEmail']="El Correo es obligatorio";
            $error = true;
        }
        else
        {
            $correo = limpiar_entrada($_POST['Email']);
            $_SESSION['email'] = $correo;
            if (!preg_match("/^[a-zA-Z]([a-zA-Z0-9-_]*[a-zA-Z0-9])?\@[a-zA-Z]([a-zA-Z-_]*[a-zA-Z])?(\.[a-zA-Z]+)+$/",$correo))
            {
                $_SESSION['errEmail'] = "El usuario del correo solo puede contener letras, números o '_' o '-', no puede empezar con números ni '-' ni '_' y no puede terminar con '-' ni '_'.</p>
                                        <p style='color: red'>Seguido debe tener un '@'.</p><p style='color: red'>Seguido debe estar el nombre del servidor, el cual solo puede contener letras o '_' o '-', 
                                        no puede empezar ni terminar con '-' o '_'.</p><p style='color: red'>Seguido van los dominios, que empieza con un '.' 
                                        seguido de letras (pueden haber varios dominios)!";
                $error = true;
            }
        }

        if(empty($_POST['ConfirmarEmail']))
        {
            $_SESSION['errConfirmarEmail']="La confirmación del Correo es obligatoria";
            $error = true;
        }
        else
        {
            $cCorreo = limpiar_entrada($_POST['ConfirmarEmail']);
            $_SESSION['confirmarEmail'] = $cCorreo;
            if (isset($correo))
            {
                if($correo != $cCorreo)
                {
                    $_SESSION['errConfirmarEmail'] = "La confirmación del correo debe ser igual al correo!";
                    $error = true;
                }  
            }
            else
            {
                $_SESSION['errConfirmarEmail'] = "Primero Ingrese el Correo!";
                $error = true;
            }
        }

        if(empty($_POST['Contraseña']))
        {
            $_SESSION['errContraseña']="La contraseña es obligatoria";
            $error = true;
        }
        else
        {
            $contraseña = limpiar_entrada($_POST['Contraseña']);
            $_SESSION['contraseña'] = $contraseña;
        }

        if($error == true)
        {
            header("Location: Registro_F.php");
        }
        else
        {
            eliminarSessionV('nombreUsuario');
            eliminarSessionV('email');
            eliminarSessionV('confirmarEmail');
            eliminarSessionV('contraseña');
        }
    }
    else
    {
        $error = true;
        header("Location: Registro_F.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Registrarse </h2>
            </div>
            <div class="container">
                <?php

                    if($error==false)
                    {
                        $cadena ="<p>";

                        if (CRYPT_SHA512 == 1) 
                        {
                            $contraseña = crypt($contraseña, '$6$rounds=5000$usesomesillystringforsaltforexamplelapujamijo$');

                            $rol = 'usuario';
                            
                            $sql = "INSERT INTO Usuarios (NombreUsuario,Rol,Contraseña,Email) VALUES ('$nombreUsuario', '$rol', '$contraseña', '$correo');";
                            if(mysqli_query($con, $sql))
                            {
                                $cadena .= "<strong>Usuario con:</strong><br><br>Nombre de Usuario: $nombreUsuario<br>Rol: $rol<br>Correo: $correo<br>
                                    <br><strong>Creado correctamente</strong>";
                            }
                            else
                            {
                                $cadena .= "Error en la creación del Usuario con nombre de usuario $nombreUsuario " . mysqli_error($con);
                            }

                            $cadena .= "</p>";
                            echo $cadena;
                        }
                        else
                        {
                            $cadena.= "Error en la encriptación de la contraseña con CRYPT_SHA512</p>";
                            echo $cadena;
                        }
                    }
                    mysqli_close($con);
                ?>
            </div>
            <div class="container">
                <a href = "Registro_F.php"><button class="btn btn-primary" type ="button">Volver</button></a>
                <a href = "Login_F.php"><button class="btn btn-primary" type ="button">Iniciar Sesión</button></a>
            </div>
        </div>
    </body>
</html>