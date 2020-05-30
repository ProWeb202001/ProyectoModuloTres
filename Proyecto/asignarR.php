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

    if(isset($_GET['id']))
    {
        $pacienteId = $_GET['id'];
        $paciente = consultarPacienteByID($pacienteId);
        $nomPaciente = $paciente->nombre;
        $medico = consultarMedicoByID($paciente->medicoID);
        $nomMedico = $medico->nombreUsuario;
        date_default_timezone_set('America/Bogota');   
        $fecha =date("Y-m-d H:i:s");
        /* $valores = explode(' ', $fecha);
        $dia = $valores[1];
        $hora = $valores[2];
        $fecha = $dia." ".$hora; */

        $recursos = obtenerRecursosDisponibles();

    }
    else
    {
        header("Location: listarPacientes.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Asignar Recurso</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Asignar Recurso</h2>
            </div>

            <div class="container">
                <p>Los campos con "*" son obligatorios</p>
            </div>

            <div class="container">
                <form action="asignR.php" method="POST">

                    <div class="form-group">
                        <label for="NombreMedico">Nombre del Médico</label>
                        <input class="form-control" type="text" name="NombreMedico" id="NombreMedico" value="<?=$nomMedico;?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="NombrePaciente">Nombre del Paciente</label>
                        <input class="form-control" type="text" name="NombrePaciente" id="NombrePaciente" value="<?=$nomPaciente;?>" readonly>
                    </div>

                    <input type="hidden" type = "text" name ="idPaciente" id="idPaciente" value="<?=$pacienteId;?>">

                    <div class="form-group">
                        <label for="Fecha">Fecha de la Solicitud</label>
                        <input class="form-control" type="text" name="Fecha" id="Fecha" value="<?=$fecha;?>" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="NombreRecurso">Nombre del Recurso *</label>
                        <select class="form-control" name="NombreRecurso" id="NombreRecurso">
                            
                            <?php
                                foreach($recursos as $r)
                                {
                                    $cadena = "<option ";
                                    if(isset($_SESSION['nombreRecurso']))
                                    {
                                        if($_SESSION['nombreRecurso'] == $r->nombre)
                                        {
                                            $cadena .= "selected";
                                        }
                                        
                                    }     
                                    $cadena .= ">$r->nombre</option>";
                                    echo $cadena;
                                }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Cantidad">Cantidad *</label>
                        <input class="form-control" type="text" name="Cantidad" id="Cantidad"
                        
                            <?php
                                if(isset($_SESSION['cantidad']))
                                {
                                    echo "value='{$_SESSION['cantidad']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errCantidad']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errCantidad']}</p>"; 
                            }                        
                        ?>
                    </div>

                    <?php
                        eliminarSessionV('errNombreRecurso');
                        eliminarSessionV('errCantidad');
                    ?>
                    <button type="submit" class="btn btn-primary">Asignar</button>
                    <a href = "paciente.php?id=<?=$pacienteId;?>"><button type="button" class="btn btn-primary">Cancelar</button></a>
                </form>
            </div>
        </div>
    </body>
</html>