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

        if(empty($_POST['Nombre']))
        {
            $_SESSION['errNombre']="El Nombre es obligatorio";
            $error = true;
        }
        else
        {
            $nombre = limpiar_entrada($_POST['Nombre']);
            $_SESSION['nombre'] = $nombre;
            if (!preg_match("/^[a-zA-Z0-9-_]+$/",$nombre))
            {
                $_SESSION['errNombre'] = "Solo letras, números, '-' o '_'!";
                $error = true;
            }
            else
            {
                $aux = consultarRecurso($nombre);
                if($aux != null)
                {
                    $_SESSION['errNombre'] = "Ya existe un Recurso con este nombre!";
                    $error = true;
                }
            }
        }

        if(empty($_POST['Cantidad']))
        {
            $_SESSION['errCantidad']="La Cantidad es obligatoria";
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
            header("Location: agregarR.php");
        }
        else
        {
            eliminarSessionV('nombre');
            eliminarSessionV('cantidad');
            
            $rec = new Recursos(null, $nombre, $cantidad);

            if(insertarRecurso($rec))
            {
                header("Location: listarRecursos.php");
            }
            else
            {
                $_SESSION['errNombre'] = "Error al crear el recurso!";
                header("Location: agregarR.php");
            }
        }
    }

?>