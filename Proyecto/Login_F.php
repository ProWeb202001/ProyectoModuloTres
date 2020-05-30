<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php
    include_once 'utils.php';
    session_start();

    eliminarSessionV('User');
    eliminarSessionV('UserID');

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Login</h2>
            </div>

            <div class="container">
                <p>Los campos con "*" son obligatorios</p>
            </div>

            <div class="container">
                <form action="Login.php" method="POST">
                    <div class="form-group">
                        <label for="NombreUsuario">Nombre de Usuario *</label>
                        <input class="form-control" type="text" name="NombreUsuario" id="NombreUsuario"
                        
                            <?php
                                if(isset($_SESSION['nombreUsuario']))
                                {
                                    echo "value='{$_SESSION['nombreUsuario']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errNombreUsuario']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errNombreUsuario']}</p>"; 
                            }                        
                        ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="Contraseña">Contraseña *</label>
                        <input class="form-control" type="password" name="Contraseña" id="Contraseña"
                        
                            <?php
                                if(isset($_SESSION['contraseña']))
                                {
                                    echo "value='{$_SESSION['contraseña']}'";
                                }     
                            ?>
                        
                        >
                        <?php
                            if(isset($_SESSION['errContraseña']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errContraseña']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <?php
                        eliminarSessionV('errNombreUsuario');
                        eliminarSessionV('errContraseña');
                    ?>
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                    <br>
                    <br>
                    <a href = "Registro_F.php">Usuario Nuevo? Registrese !</a>
                </form>
            </div>
        </div>
    </body>
</html>