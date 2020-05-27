<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php en la carpeta anterior
2. crearTabla.php en la carpeta anterior
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
        $cadena = "<p>Es necesario otorgar un ID para identificar al paciente</p>";
    }

    if($error == false)
    {
        $paciente = consultarPacienteByID($id);
        if($paciente!=null)
        {
            $medico = consultarMedicoByID($id); 
            $cama = consultarCamaByID($paciente->camaID); 
            $habitacion =consultarHabitacionByID($cama->habID); 
            $equipos = obtenerEquiposByPaciente($id); 
        }
        else
        {
            $cadena.="<p>No existe un paciente con <strong>ID:</strong> $id</p>";
            $error = true;
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Paciente</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">

            <div class="container">
                <h2>Paciente</h2>
            </div>
            <div class="container">
                <?php

                    if($error==false)
                    {
                        $cadena = "<p><strong>Identificación: </strong>$paciente->identificacion &nbsp&nbsp&nbsp&nbsp";
                        $cadena.= "<strong>Nombre: </strong>$paciente->nombre &nbsp&nbsp&nbsp&nbsp";
                        $cadena.= "<strong>Prioridad: </strong>$paciente->prioridad</p>";
                        $cadena.= "<p><strong>Fecha de Ingreso: </strong>$paciente->fechaIngreso &nbsp&nbsp&nbsp&nbsp";
                        $cadena.= "<strong>Duración en Dias: </strong>$paciente->duracionDias</p>";
                        $cadena.= "<p><strong>Habitación: </strong>$habitacion->numero &nbsp&nbsp&nbsp&nbsp";
                        $cadena.= "<strong>Cama: </strong>$cama->numero</p>";
                        $cadena.= "<p><strong>Medico: </strong>$medico->nombreUsuario</p>";
                        $cadena.= "<p><strong>Diagnostico: </strong></p>"; 
                        $cadena.= "<p>$paciente->diagnostico</p>";

                        $cadena.= "<p><strong>Equipos asignados: </strong></p>"; 
                        $cadena.= "<table class='table'>
                                        <thead>
                                            <tr>
                                                <th scope='col'>ID</th>
                                                <th scope='col'>Nombre</th>
                                                <th scope='col'>Fecha de pedido</th>
                                                <th scope='col'>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                        foreach($equipos as $c)
                        {
                            $cadena.="<tr>";
                            $cadena .= "<td>".$c->id."</td>";
                            $valores = explode(' ', $c->fechaPedido);
                            $cadena .= "<td>".$c->nombre."</td>";
                            $cadena .= "<td>".$valores[0]."</td>";
                            $cadena .= "<td>".$c->cantidad."</td>";
                            
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
                <a <?php if(!$admin){echo "style='display: none'";} ?>href = "listarEquipos.php?id=<?php echo $id; ?>"><button class="btn btn-primary" type ="button">Editar asignación equipos</button></a>
                <a href = "listarPacientes.php"><button class="btn btn-primary" type ="button">Volver</button></a>                
            </div>
        </div>
    </body>
</html>