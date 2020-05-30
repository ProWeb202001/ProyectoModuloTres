<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php
    session_start();

    include_once 'utils.php';
    include_once 'model.php';

    include_once 'config.php';

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
                $aux = consultarUsuario($nombreUsuario);
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
            if (!preg_match("/^[a-zA-Z]([a-zA-Z0-9-_\.]*[a-zA-Z0-9])?\@[a-zA-Z]([a-zA-Z-_]*[a-zA-Z])?(\.[a-zA-Z]+)+$/",$correo))
            {
                $_SESSION['errEmail'] = "El usuario del correo solo puede contener letras, números, '.', '_' o '-', no puede empezar con números ni '-' ni '_' y no puede terminar con '-' ni '_'.</p>
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

                        $usuario = new Usuario(null,$nombreUsuario,$correo,$contraseña,'medico');

                        if(insertarusuario($usuario))
                        {
                            $cadena .= "<strong>Usuario con:</strong><br><br>Nombre de Usuario: $nombreUsuario<br>Rol: $usuario->rol<br>Correo: $correo<br>
                                <br><strong>Creado correctamente</strong>";
                        }
                        else
                        {
                            $cadena .= "Error en la creación del Usuario con nombre de usuario $nombreUsuario ";
                        }

                        $cadena .= "</p>";
                        echo $cadena;

                    }
                ?>
            </div>
            <div class="container">
                <a href = "Registro_F.php"><button class="btn btn-primary" type ="button">Volver</button></a>
                <a href = "Login_F.php"><button class="btn btn-primary" type ="button">Iniciar Sesión</button></a>
            </div>
        </div>
    </body>
</html>