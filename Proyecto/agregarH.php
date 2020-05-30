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

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agregar Habitación</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Agregar Habitación</h2>
            </div>

            <div class="container">
                <p>Los campos con "*" son obligatorios</p>
            </div>

            <div class="container">
                <form action="addH.php" method="POST">
                    <div class="form-group">
                        <label for="Numero">Número de Habitación *</label>
                        <input class="form-control" type="text" name="Numero" id="Numero"
                        
                            <?php
                                if(isset($_SESSION['numero']))
                                {
                                    echo "value='{$_SESSION['numero']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errNumero']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errNumero']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <?php
                        eliminarSessionV('errNumero');
                    ?>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <a href = "listarHabitaciones.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
                </form>
            </div>
        </div>
    </body>
</html>