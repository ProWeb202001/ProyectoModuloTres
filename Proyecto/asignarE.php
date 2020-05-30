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
        $pacienteID = $_POST['idPaciente'];
        $fecha = $_POST['Fecha'];
        $nombreE = $_POST['NombreEquipo'];

        $_SESSION['nombreEquipo'] = $nombreE;

        $aux = consultarEquipo($nombreE);
        echo $aux->nombre;
        if($aux->cantidad == 0)
        {
            $_SESSION['errCantidad'] = "No hay cantidad de este equipo !";
            $error = true;
        }
        if($error == true)
        {
            // header("Location: asignarEquipos.php?id=".$pacienteID);
        }
        else
        {
            eliminarSessionV('nombreRecurso');

            $equipo = consultarEquipo($nombreE);
            $equipoA = new EquipoAsignado(null, $equipo->id, $pacienteID, $fecha, 1, null);
            $aux = obtenerEquipoAsignadosByPaciente_Equipo($pacienteID, $equipo->id);
            $aux2 = obtenerMensajesByEquipoPaciente($pacienteID, $equipo->id); 
                
            if($aux == null && $aux2 == null)
            {
                $aux3 = obtenerEquiposByPaciente($pacienteID);    
                $aux4 = obtenerMensajesByPaciente($pacienteID); 
                $paciente = consultarPacienteByID($pacienteID); 
                $cantidad = count($aux3); 
                $cantidad2 = count($aux4); 
                $bandera = 0;
                if($paciente->prioridad =="Alta" && ($cantidad + $cantidad2) < 3)
                {
                    $bandera= 1; 
                }
                else if($paciente->prioridad =="Media" &&  ($cantidad + $cantidad2) < 2)
                {
                    $bandera= 1; 
                }
                else if($paciente->prioridad =="Baja" &&  ($cantidad + $cantidad2) < 1)
                {
                    $bandera= 1; 
                }
                if($bandera == 1 && insertarMensaje($equipoA))
                {
                    header("Location: paciente.php?id=".$pacienteID);
                }
                else if($bandera == 0)
                {
                    $_SESSION['errCantidad'] = "Según su prioridad no puede pedir mas equipos!";
                    header("Location: asignarEquipos.php?id=".$pacienteID);
                }
                else
                {
                    $_SESSION['errCantidad'] = "Error al solicitar el equipo!";
                    header("Location: asignarEquipos.php?id=".$pacienteID);
                }
            }
            else if($aux != null)
            {

                $_SESSION['errCantidad'] = "Error al Asignar el equipo! Ya tiene asignado este equipo";
                header("Location: asignarEquipos.php?id=".$pacienteID);
            }
            else if($aux2 != null)
            {

                $_SESSION['errCantidad'] = "Ya mando una petición para este equipo";
                header("Location: asignarEquipos.php?id=".$pacienteID);
            }
            
        }
    }

?>