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
        $id = (int)$_POST['id'];
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

                $aux = consultarCamaH($numero,$id);
                if($aux != null)
                {
                    $_SESSION['errNumero'] = "Ya existe una Cama con este número!";
                    $error = true;
                }
            }
        }

        
        if($error == true)
        {
            header("Location: agregarC.php?id=".$id);
        }
        else
        {
            eliminarSessionV('numero');
            $cama = new Camas(null, $numero, $id);

            if(insertarCama($cama))
            {
                $habitacion = consultarCama($numero);
                header("Location: habitacion.php?id=".$id);
            }
            else
            {
                $_SESSION['errNumero'] = "Error al crear la Cama!";
                header("Location: agregarC.php?id=".$id);
            }
        }
    }

?>