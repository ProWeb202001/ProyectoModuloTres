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

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
    }
    else
    {
        $error = true;
        $cadena = "<p>Es necesario otorgar un ID para identificar la habitación</p>";
    }

    if($error == false)
    {
        $habitacion = consultarHabitacionByID($id);
        if($habitacion!=null)
        {
            if($admin)
            {
                $camas = obtenerCamasHabitacion($id);
            }
            else
            {
                $camas = obtenerCamasDisponiblesByHabID($id);
            }
        }
        else
        {
            $cadena.="<p>No existe una habitación con <strong>ID:</strong> $userID</p>";
            $error = true;
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Habitación</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Habitación</h2>
            </div>
            <div class="container">
                <?php

                    if($error==false)
                    {
                        $cadena = "<p><strong>Número: </strong>$habitacion->numero</p>";
                        if($admin)
                        {
                            $cadena.= "<p><strong>Camas: </strong></p>";
                        }
                        else
                        {
                            $cadena.= "<p><strong>Camas Disponibles: </strong></p>";
                        }
                        $cadena.= "<table class='table'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>ID</th>
                                                <th scope='col'>Número</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                        foreach($camas as $c)
                        {
                            $cadena.="<tr>";
                            if($admin)
                            {
                                $cadena .= "<td>".$c->id."</td>";
                            }
                            else
                            {
                                $cadena .= "<td><a href='agregarPaciente.php?id=$c->id'>".$c->id."</a></td>";
                            }
                            $cadena .= "<td>".$c->numero."</td>";
                            $cadena .= "</tr>";
                        }
                        $cadena.= "</tbody>
                            </table>";
                        echo $cadena;
                    }
                    else
                    {
                        echo $cadena;
                    }
                ?>
                <a <?php if(!$admin){echo "style='display: none'";} ?> href = "agregarC.php?id=<?php echo $id; ?>"><button class="btn btn-primary" type ="button">+</button></a>
                <a href = "listarHabitaciones.php"><button class="btn btn-primary" type ="button">Volver</button></a>                
            </div>
        </div>
    </body>
</html>