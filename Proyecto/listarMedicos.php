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

    if($error == false)
    {
        $medicos = obtenerMedicos();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Visualizar Medicos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Visualizar Medicos</h2>
            </div>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nombre de Usuario</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cadena = "";
                            foreach($medicos as $m)
                            {
                                $cadena.="<tr>";
                                $cadena .= "<td><a href='perfil.php?id=".$m->id."'>".$m->nombreUsuario."</a></td>";
                                $cadena .= "<td>".$m->email."</td>";
                                $cadena .= "</tr>";
                            }
                            echo $cadena;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <a href = "admin.php"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>