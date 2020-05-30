<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php
    session_start();

    include_once 'config.php';
    include_once 'utils.php';
    include_once 'model.php';

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
                if (compararPassword($usuario->password, $contraseña))
                {
                    eliminarSessionV('nombreUsuario');
                    if($usuario->rol == "medico")
                    {
                        $_SESSION['User']='medico';
                        header("Location: medico.php");
                    }
                    elseif($usuario->rol == "admin")
                    {
                        $_SESSION['User']='admin';
                        header("Location: admin.php");
                    }
                    $_SESSION['UserID']=$usuario->id;
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