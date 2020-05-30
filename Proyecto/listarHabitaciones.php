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
    $admin = true;

    if(isset($_SESSION['User']))
    {
        if($_SESSION['User'] == "medico")
        {
            $admin = false;
        }
    }
    else
    {
        $error = true;
        header("Location: Login_F.php");
    }

    if($error == false)
    {
        if($admin)
        {
            $habitaciones = obtenerHabitaciones();
        }
        else
        {
            $habitaciones = obtenerHabitacionesDisponibles();
            $disponible = "Disponibles";
        }
        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Visualizar Habitaciones <?php if(!$admin){echo $disponible;} ?></title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Visualizar Habitaciones <?php if(!$admin){echo $disponible;} ?></h2>
            </div>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Número</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cadena = "";
                            foreach($habitaciones as $h)
                            {
                                $cadena.="<tr>";
                                $cadena .= "<td><a href='habitacion.php?id=".$h->id."'>".$h->id."</a></td>";
                                $cadena .= "<td>".$h->numero."</td>";
                                $cadena .= "</tr>";
                            }
                            echo $cadena;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <a <?php if(!$admin){echo "style='display: none'";} ?> href = "agregarH.php"><button class="btn btn-primary" type ="button">+</button></a>
                <a href = "<?php if(!$admin){echo "medico.php";}else{echo "admin.php";} ?>"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>