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
        $idPaciente = $_POST['NombrePaciente'];
        $idPacienteActual =  $_POST['idPacienteActual'];

        $pacienteActual = consultarPacienteByID($idPacienteActual); 
        $pacienteNuevo = consultarPacienteByID($idPaciente);
        
        echo "IDEquipo: ".$id;
        echo "\nIdPaciente: ".$idPaciente;
        echo "\nIdActual: ".$idPacienteActual;
        if(($pacienteNuevo->prioridad == "Alta" && $pacienteActual->prioridad != "Alta")|| ($pacienteNuevo->prioridad == "Media" && $pacienteActual->prioridad == "Baja"))
        {
            $equipo = obtenerEquipoAsignadoByID($id);
            $equipo->pacienteID = $idPaciente;
            if($equipo != null)
            {
                if(updateEquipoAsignado($equipo))
                {
                    header("Location: listarEquipos.php");
                }
                else
                {
                    $_SESSION['errCantidad'] = "Error al modificar la asignación del equipo!";
                    header("Location: modificarEquipoAsignado.php?id=".$id);
                }
            }
            else
            {
                $_SESSION['errCantidad'] = "Error al encontrar el equipo!";
                header("Location: modificarEquipoAsignado.php?id=".$id);
            }
        }
        else
        {
            $_SESSION['errCantidad'] = "Error, NO se puede reasignar un equipo  de un paciente con una prioridad mayor!";
            header("Location: modificarEquipoAsignado.php?id=".$id);
        } 
            
    }

?>