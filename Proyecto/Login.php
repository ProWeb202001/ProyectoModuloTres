<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php en la carpeta anterior
2. crearTabla.php en la carpeta anterior
-->

<?php
    session_start();

    include_once 'config.php';
    include_once 'utils.php';

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
        }

        if(empty($_POST['Contraseña']))
        {
            $_SESSION['errContraseña']="La contraseña es obligatoria";
            $error = true;
        }
        else
        {
            $contraseña = limpiar_entrada($_POST['Contraseña']);
        }

        if($error == true)
        {
            header("Location: Login_F.php");
        }
        else
        {
            $usuario = consultarUsuario($nombreUsuario);
            if($usuario != null)
            {
                if (compararPassword($usuario['Contraseña'], $contraseña))
                {
                    eliminarSessionV('nombreUsuario');
                    if($usuario['Rol'] == "usuario")
                    {
                        $_SESSION['User']='usuario';
                        header("Location: perfil.php?id=".$usuario['UserID']);
                    }
                    elseif($usuario['Rol'] == "admin")
                    {
                        $_SESSION['User']='admin';
                        header("Location: verUsuarios.php");
                    }
                    $_SESSION['UserID']=$usuario['UserID'];
                }
                else
                {
                    $_SESSION['errContraseña']="Contraseña incorrecta!";
                    header("Location: Login_F.php");
                }
                
            }
            else
            {
                $_SESSION['errNombreUsuario']="No se encontró un usuario con esta información!";
                header("Location: Login_F.php");
            }
        }
    }

?>