<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php
    session_start();
    include_once 'utils.php';

    if(isset($_SESSION['User']))
    {
        if($_SESSION['User'] == "admin")
        {
            $error = true;
            header("Location: admin.php");
        }
    }
    else
    {
        $error = true;
        header("Location: Login_F.php");
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Médico</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Médico</h2>
            </div>

            <div class="container">
                <a href="listarHabitaciones.php"><button type="button" class= "btn btn-primary">Visualizar Habitaciones</button></a>
                <a href="listarPacientes.php"><button type="button" class= "btn btn-primary">Visualizar Pacientes</button></a>
                <br>
                <br>
                <a href="Login_F.php"><button type="button" class= "btn btn-primary">Salir</button></a>
            </div>
        </div>
    </body>
</html>