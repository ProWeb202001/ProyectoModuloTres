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
            header("Location: medico.php");
        }
    }
    else
    {
        $error = true;
        header("Location: Login_F.php");
    }

    if($error == false)
    {
        $recursos = obtenerRecursos();        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Visualizar Recursos></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Visualizar Recursos</h2>
            </div>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cadena = "";
                            foreach($recursos as $r)
                            {
                                $cadena.="<tr>";
                                $cadena .= "<td><a href='modificarRecurso.php?id=".$r->id."'>".$r->id."</a></td>";
                                $cadena .= "<td>".$r->nombre."</td>";
                                $cadena .= "<td>".$r->cantidad."</td>";
                                $cadena .= "</tr>";
                            }
                            echo $cadena;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <a href = "agregarR.php"><button class="btn btn-primary" type ="button">+</button></a>
                <a href = "admin.php"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>