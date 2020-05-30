<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php

    include_once 'config.php';
    include_once 'utils.php';
    include_once 'model.php';

    session_start();

    $error = false;
    $cadena ="";

    if(isset($_SESSION['User']))
    {
        if($_SESSION['User'] == "medico")
        {
            $error = true;
            header("Location: medico.php?id=".$_SESSION['UserID']);
        }
    }
    else
    {
        $error = true;
        header("Location: Login_F.php");
    }

    if(isset($_GET['id']))
    {
        $userID = $_GET['id'];
    }
    else
    {
        $error = true;
        $cadena = "<p>Es necesario agregar un ID para identificar el perfil del usuario</p>";
    }

    if($error == false)
    {
        $medico = consultarUsuarioById($userID);
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Perfil</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Perfil Medico</h2>
            </div>
            <div class="container">
                <?php

                    if($error==false)
                    {
                        if($medico != null)
                        {
                            
                            $cadena.="<br><p><strong>ID:</strong> $userID</p>";
                            $cadena.="<p><strong>Nombre: </strong>{$medico->nombreUsuario}</p>";
                            $cadena.="<p><strong>Correo Electrónico: </strong>{$medico->email}</p>";

                            $cadena.="<form action='cambiarRol.php' method='POST'>
                                        <input type='hidden' name='id' id='id' value='$userID'>
                                        <div class='form-group'>
                                            <label for='Rol'><strong>Rol</strong></label>
                                            <select class='form-control' name='Rol' id='Rol'>
                                                <option selected>medico</option>
                                                <option>admin</option>
                                            </select>
                                        </div>                
                                        <button type='submit' class='btn btn-primary'>Guardar</button>
                                    </form>";
                        }
                        else
                        {
                            $cadena.="<p>No existe un Usuario con <strong>ID:</strong> $userID</p>";
                        }
                        $cadena .= "<br>";
                        echo $cadena;
                    }
                    else
                    {
                        echo $cadena;
                    }
                ?>
                <a href = "listarMedicos.php"><button class="btn btn-primary" type ="button">Volver</button></a>                
            </div>
        </div>
    </body>
</html>