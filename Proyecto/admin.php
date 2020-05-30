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

    $cadena = "";
    $mensajes = obtenerMensajes();
    $mensajes = ordenarPorPrioridad($mensajes);
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrador</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Administrador</h2>
            </div>

            <div class="container">
                <a href="listarMedicos.php"><button type="button" class= "btn btn-primary">Visualizar Medicos</button></a>
                <a href="listarHabitaciones.php"><button type="button" class= "btn btn-primary">Visualizar Habitaciones</button></a>
                <a href="listarPacientes.php"><button type="button" class= "btn btn-primary">Visualizar Pacientes</button></a>
                <a href="listarRecursos.php"><button type="button" class= "btn btn-primary">Visualizar Recursos</button></a>
                <a href="listarEquipos.php"><button type="button" class= "btn btn-primary">Visualizar Equipos</button></a>
                <br>
                <br>
                <h5><strong>Centro de mensajes: </strong></h5>
                <?php
                    
                    if(count($mensajes)==0)
                    {
                        $cadena .= "</tbody></table><div style='text-align: center;'><strong>Buzón Vacío</strong></div>";
                    }
                    else
                    {
                        $cadena.= "<table class='table'>
                                    <thead>
                                        <tr>
                                            <th scope='col'>ID</th>
                                            <th scope='col'>Nombre</th>
                                            <th scope='col'>Nombre Paciente</th>
                                            <th scope='col'>Prioridad</th>
                                            <th scope='col'>Fecha de pedido</th>
                                            <th scope='col'>Cantidad</th>
                                            <th scope='col'>Aceptar</th>
                                            <th scope='col'>Rechazar</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                        foreach($mensajes as $m)
                        {
                            $equipo = consultarEquipoByID($m->equipoID);
                            $paciente = consultarPacienteByID($m->pacienteID);
                            $cadena.="<tr>";
                            $cadena .= "<td>".$m->id."</td>";
                            $cadena .= "<td>".$m->nombre."</td>";
                            $cadena .= "<td>".$paciente->nombre."</td>";
                            $cadena .= "<td style='color: red'>".$paciente->prioridad."</td>";
                            $cadena .= "<td>".$m->fechaPedido."</td>";
                            $cadena .= "<td>".$m->cantidad."</td>";
                            if($equipo->cantidad > 0)
                            {
                                $cadena .= "<td><a href='aceptarSolicitud.php?id=$m->id'>Aceptar</a></td>";
                            }
                            else
                            {
                                $cadena .= "<td></td>";
                            }
                            $cadena .= "<td><a href='rechazarSolicitud.php?id=$m->id'>Rechazar</a></td></tr>";                            
                        }
                        $cadena.= "</tbody>
                            </table>";
                    
                    }
                    if(isset($_SESSION['error']))
                    {
                        $cadena .= "<p style='color: red'>{$_SESSION['error']}</p>"; 
                    }
                    if(isset($_SESSION['correcto']))
                    {
                        $cadena .= "<p style='color: blue'>{$_SESSION['correcto']}</p>"; 
                    }     
                    echo $cadena;

                    eliminarSessionV('error');
                    eliminarSessionV('correcto');
                ?>
                <br>
                <br>
                <a href="Login_F.php"><button type="button" class= "btn btn-primary">Salir</button></a>
            </div>
        </div>
    </body>
</html>