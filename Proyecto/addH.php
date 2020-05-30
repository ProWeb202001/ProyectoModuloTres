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

        if(empty($_POST['Numero']))
        {
            $_SESSION['errNumero']="El Número es obligatorio";
            $error = true;
        }
        else
        {
            $numero = limpiar_entrada($_POST['Numero']);
            $_SESSION['numero'] = $numero;
            if (!preg_match("/^[0-9]+$/",$numero))
            {
                $_SESSION['errNumero'] = "Solo números!";
                $error = true;
            }
            else
            {
                $aux = consultarHabitacion($numero);
                if($aux != null)
                {
                    $_SESSION['errNumero'] = "Ya existe una Habitación con este número!";
                    $error = true;
                }
            }
        }

        if($error == true)
        {
            header("Location: agregarH.php");
        }
        else
        {
            eliminarSessionV('numero');
            
            $hab = new Habitacion(null, $numero);

            if(insertarHabitacion($hab))
            {
                $habitacion = consultarHabitacion($numero);
                header("Location: habitacion.php?id=".$habitacion->id);
            }
            else
            {
                $_SESSION['errNumero'] = "Error al crear la Habitación!";
                header("Location: agregarH.php");
            }
        }
    }

?>