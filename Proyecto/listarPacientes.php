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
            $pacientes = obtenerPacientes();
        }
        else
        {
            $medicoID = $_SESSION['UserID'];
            $pacientes = obtenerPacientesByMedico($medicoID);
        }
        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Visualizar Pacientes </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Visualizar Pacientes</h2>
            </div>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Identificación</th>
                            <th scope="col">Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cadena = "";
                            foreach($pacientes as $h)
                            {
                                $cadena.="<tr>";
                                $cadena .= "<td><a href='paciente.php?id=".$h->pid."'>".$h->pid."</a></td>";
                                $cadena .= "<td>".$h->identificacion."</td>";
                                $cadena .= "<td>".$h->nombre."</td>";
                                $cadena .= "</tr>";
                            }
                            echo $cadena;
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="container">
                <a href = "<?php if(!$admin){echo "medico.php";}else{echo "admin.php";} ?>"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>