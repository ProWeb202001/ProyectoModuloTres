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
        $equiposDisponibles = obtenerEquiposDisponibles(); 
        $equiposAsignados = obtenerEquiposAsignados();        
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>VisualizarEquipos</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Visualizar Equipos</h2>
            </div>
            <div class="container">
                <h5>Equipos Disponibles</h5>
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
                            foreach($equiposDisponibles as $r)
                            {
                                $cadena.="<tr>";
                                $cadena .= "<td><a href='modificarEquipo.php?id=".$r->id."'>".$r->id."</a></td>";
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
                <a href = "agregarEquipos.php"><button class="btn btn-primary" type ="button">+</button></a>  
            </div>
            <br>
            <br>
            <div class="container">
                <h5>Equipos Asignados</h5>
            </div>
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Nombre del Paciente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cadena = "";
                            foreach($equiposAsignados as $r)
                            {
                                $paciente = consultarPacienteByID($r->pacienteID);
                                $cadena.="<tr>";
                                $cadena .= "<td><a href='modificarEquipoAsignado.php?id=".$r->id."'>".$r->id."</a></td>";
                                $cadena .= "<td>".$r->nombre."</td>";
                                $cadena .= "<td>".$r->cantidad."</td>";
                                $cadena .= "<td>".$paciente->nombre."</td>";
                                $cadena .= "</tr>";
                            }
                            echo $cadena;
                        ?>
                    </tbody>
                </table>
            </div>
            <div>
                <a href = "admin.php"><button class="btn btn-primary" type ="button">Volver</button></a>
            </div>
        </div>
    </body>
</html>