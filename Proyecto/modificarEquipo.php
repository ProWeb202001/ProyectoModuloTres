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

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
        $equipo = consultarEquipoByID($id);

    }
    else
    {
        header("Location: listarEquipos.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agregar Equipo</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Agregar Equipo</h2>
            </div>

            <div class="container">
                <p>Los campos con "*" son obligatorios</p>
            </div>

            <div class="container">
                <form action="updE.php" method="POST">

                    <div class="form-group">
                        <label for="NombreEquipo">Nombre del equipo</label>
                        <input class="form-control" type="text" name="NombreEquipo" id="NombreEquipo" value="<?=$equipo->nombre;?>" readonly>
                    </div>

                    <input type="hidden" type = "text" name ="idEquipo" id="idEquipo" value="<?=$equipo->id;?>">

                    <div class="form-group">
                        <label for="Cantidad">Cantidad del equipo a añadir*</label>
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
                        eliminarSessionV('errCantidad');
                    ?>
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <a href = "listarEquipos.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
                </form>
            </div>
        </div>
    </body>
</html>