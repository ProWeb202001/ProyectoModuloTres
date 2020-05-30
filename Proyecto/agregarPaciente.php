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
        else
        {
            $medicoID = $_SESSION['UserID'];
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
        header("Location: listarHabitaciones.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agregar Paciente</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Agregar Paciente</h2>
            </div>

            <div class="container">
                <p>Los campos con "*" son obligatorios</p>
            </div>

            <div class="container">
                <form action="addPaciente.php" method="POST">

                    <div class="form-group">
                        <label for="Identificacion">Identificación *</label>
                        <input class="form-control" type="text" name="Identificacion" id="Identificacion"
                        
                            <?php
                                if(isset($_SESSION['identificacion']))
                                {
                                    echo "value='{$_SESSION['identificacion']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errIdentificacion']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errIdentificacion']}</p>"; 
                            }                        
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="Nombre">Nombre *</label>
                        <input class="form-control" type="text" name="Nombre" id="Nombre"
                        
                            <?php
                                if(isset($_SESSION['nombre']))
                                {
                                    echo "value='{$_SESSION['nombre']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errNombre']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errNombre']}</p>"; 
                            }                        
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="Diagnostico">Diagnostico *</label>
                        <textarea class="form-control" name="Diagnostico" id="Diagnostico" rows="4" cols="50">
                        
                            <?php
                                if(isset($_SESSION['diagnostico']))
                                {
                                    echo "{$_SESSION['diagnostico']}";
                                }     
                            ?>

                        </textarea>
                        <?php
                            if(isset($_SESSION['errDiagnostico']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errDiagnostico']}</p>"; 
                            }                        
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="Prioridad">Prioridad *</label>
                        <select class="form-control" name="Prioridad" id="Prioridad">
                            
                            <option
                                <?php
                                    if(isset($_SESSION['prioridad']))
                                    {
                                        if($_SESSION['prioridad'] == "Alta")
                                        {
                                            echo "selected";
                                        }
                                        
                                    }     
                                ?>
                            >Alta</option>

                            <option
                                <?php
                                    if(isset($_SESSION['prioridad']))
                                    {
                                        if($_SESSION['prioridad'] == "Media")
                                        {
                                            echo "selected";
                                        }
                                        
                                    }     
                                ?>
                            >Media</option>

                            <option
                                <?php
                                    if(isset($_SESSION['prioridad']))
                                    {
                                        if($_SESSION['prioridad'] == "Baja")
                                        {
                                            echo "selected";
                                        }
                                        
                                    }     
                                ?>
                            >Baja</option>
                        </select>
                        <?php
                            if(isset($_SESSION['errPrioridad']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errPrioridad']}</p>"; 
                            }                        
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="FechaIngreso">Fecha de Ingreso *</label>
                        <input class="form-control" type="text" name="FechaIngreso" id="FechaIngreso"
                        
                            <?php
                                if(isset($_SESSION['fechaIngreso']))
                                {
                                    echo "value='{$_SESSION['fechaIngreso']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errFechaIngreso']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errFechaIngreso']}</p>"; 
                            }                        
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="DuracionDias">Duracion en Días *</label>
                        <input class="form-control" type="text" name="DuracionDias" id="DuracionDias"
                        
                            <?php
                                if(isset($_SESSION['duracionDias']))
                                {
                                    echo "value='{$_SESSION['duracionDias']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errDuracionDias']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errDuracionDias']}</p>"; 
                            }                        
                        ?>
                    </div>

                    <input type="hidden" name="CamaID" id="CamaID" value='<?php echo "$id"; ?>'>

                    <input type="hidden" name="MedicoID" id="MedicoID" value='<?php echo "$medicoID"; ?>'>

                    <?php
                        eliminarSessionV('errIdentificacion');
                        eliminarSessionV('errNombre');
                        eliminarSessionV('errDiagnostico');
                        eliminarSessionV('errPrioridad');
                        eliminarSessionV('errFechaIngreso');
                        eliminarSessionV('errDuracionDias');
                    ?>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <a href = "habitacion.php?id=<?php $cama = consultarCamaByID($id); echo $cama->habID; ?>"><button type="button" class="btn btn-primary">Cancelar</button></a>
                </form>
            </div>
        </div>
    </body>
</html>