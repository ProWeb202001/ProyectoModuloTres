<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php

    include_once 'config.php';
    include_once 'utils.php';
    include_once 'model.php';

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $medico = consultarUsuarioById($_POST['id']);
    }
    else
    {
        header("Location: listarMedicos.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cambiar Rol</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Cambiar Rol</h2>
            </div>
            <div class="container">
                <?php

                    if($_SERVER["REQUEST_METHOD"] == "POST")
                    {
                        $cadena ="<p>";
                        if($medico != null)
                        {
                            $medico->rol = $_POST['Rol'];
                            if(updateUsuario($medico))
                            {
                                $cadena .= "<strong>El Rol del Usuario con:</strong><br><br>Id: $medico->id<br><br><strong>Ha sido modificado correctamente</strong>";
                            }
                            else
                            {
                                $cadena .= "Error en la Actualización del Usuario con id: $medico->id " . mysqli_error($con);
                            }
                        }
                        else
                        {
                            $cadena .= "El usuario con id $medico->id no existe";
                        }
                        $cadena .= "</p>";
                        echo $cadena;
                    }

                ?>
            </div>
            <div class="container">
                <a href = "listarMedicos.php"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>