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

    $error = false;

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];
    }
    else
    {
        $error = true;
    }

    if($error == true)
    {
        header("Location: admin.php");
    }
    else
    {
        $mensaje = obtenerMensajeByID($id);

        $paciente = consultarPacienteByID($mensaje->pacienteID);

        $medico = consultarUsuarioByID($paciente->medicoID);

        $equipo = consultarEquipoByID($mensaje->equipoID);

        $correo = $medico->email;

        $msg = "La solicitud ha sido rechazada\n";
        $msg .= "La información del equipo rechazado es: \n";
        $msg .= "Identificación del Paciente: $paciente->identificacion\n";
        $msg .= "Nombre del Paciente: $paciente->nombre\n";
        $msg .= "Nombre del Equipo: $equipo->nombre\n";
        $msg .= "Fecha de la Solicitud: $mensaje->fechaPedido\n";

        if($mensaje != null)
        {
            if(enviarCorreo($correo, "Solicitud de Equipo Rechazada", $msg))
            {
                if(eliminarMensaje($mensaje))
                {
                    $_SESSION['correcto'] = "Solicitud rechazada exitosamente!";
                }
                else
                {
                    $_SESSION['error'] = "Error al Rechazar la solicitud!";
                }
                header("Location: admin.php");
            }
            else
            {
                $_SESSION['error'] = "Error al enviar correo!";
                header("Location: admin.php");
            }
        }
        else
        {
            $_SESSION['error'] = "Error al encontrar la solicitud!";
            header("Location: admin.php");
        }
        
    }
    

?>