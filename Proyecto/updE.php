<!--
Antes de mostar esta página se debió ejecutar lo siguiente 
1. crearDb.php
2. crearTabla.php
-->

<?php
    session_start();

    include_once 'config.php';
    include_once 'utils.php';
    include_once 'model.php';

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $error = false;
        $id = $_POST['idEquipo'];

        if(empty($_POST['Cantidad']))
        {
            $_SESSION['errCantidad']="La Cantidad es obligatoria !";
            $error = true;
        }
        else
        {
            $cantidad = limpiar_entrada($_POST['Cantidad']);
            $_SESSION['cantidad'] = $cantidad;
            if (!preg_match("/^[0-9]+$/",$cantidad))
            {
                $_SESSION['errCantidad'] = "Solo números!";
                $error = true;
            }
        }

        if($error == true)
        {
            header("Location: modificarEquipo.php?id=".$id);
        }
        else
        {
            eliminarSessionV('cantidad');

            $equipo = consultarEquipoByID($id);
            $cantAux = (int)$equipo->cantidad + (int)$cantidad;
            $equipo->cantidad = $cantAux;

            if($equipo != null)
            {
                if(updateEquipo($equipo))
                {
                    header("Location: listarEquipos.php");
                }
                else
                {
                    $_SESSION['errCantidad'] = "Error al Agregar el equipo!";
                    header("Location: modificarEquipo.php?id=".$id);
                }
            }
            else
            {
                $_SESSION['errCantidad'] = "Error al encontrar el equipo!";
                header("Location: modificarEquipo.php?id=".$id);
            }
            
        }
    }

?>