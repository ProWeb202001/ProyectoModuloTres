<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php
    session_start();
    include_once 'utils.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    </head>
    <body>
        <div class="container" style="border-radius: 30px;border: solid;padding: 30px;margin-top: 3%;">
            <div class="container">
                <h2>Registrarse</h2>
            </div>

            <div class="container">
                <p>Los campos con "*" son obligatorios</p>
            </div>

            <div class="container">
                <form action="Registro.php" method="POST">
                
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
                        <label for="Email">Email *</label>
                        <input class="form-control" type="text" name="Email" id="Email"
                        
                            <?php
                                if(isset($_SESSION['email']))
                                {
                                    echo "value='{$_SESSION['email']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errEmail']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errEmail']}</p>"; 
                            }                        
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="ConfirmarEmail">Confirmar Email *</label>
                        <input class="form-control" type="text" name="ConfirmarEmail" id="ConfirmarEmail"
                        
                            <?php
                                if(isset($_SESSION['confirmarEmail']))
                                {
                                    echo "value='{$_SESSION['confirmarEmail']}'";
                                }     
                            ?>

                        >
                        <?php
                            if(isset($_SESSION['errConfirmarEmail']))
                            {
                                echo "<p style='color: red'>{$_SESSION['errConfirmarEmail']}</p>"; 
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
                        eliminarSessionV('errEmail');
                        eliminarSessionV('errConfirmarEmail');
                        eliminarSessionV('errContraseña');
                    ?>
                    <button type="submit" class="btn btn-primary">Registrarse</button>
                    <br>
                    <br>
                    <a href = "Login_F.php">Ya estas registrado? Inicia Sesión !</a>
                </form>
            </div>
        </div>
    </body>
</html>