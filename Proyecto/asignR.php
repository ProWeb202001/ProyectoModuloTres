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
        $nombreR = $_POST['NombreRecurso'];

        $_SESSION['nombreRecurso'] = $nombreR;

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
            else
            {

                $aux = consultarRecurso($nombreR);
                if($aux->cantidad == 0)
                {
                    $_SESSION['errCantidad'] = "No hay cantidad de este recurso !";
                    $error = true;
                }
                else if($aux->cantidad < $cantidad)
                {
                    $_SESSION['errCantidad'] = "No hay suficiente de este recurso ! Solo hay $aux->cantidad unidades";
                    $error = true;
                }
            }
        }

        if($error == true)
        {
            header("Location: asignarR.php?id=".$pacienteID);
        }
        else
        {
            eliminarSessionV('nombreRecurso');
            eliminarSessionV('cantidad');

            $recurso = consultarRecurso($nombreR);
            $recursoA = new Recursos_Asignados($recurso->id, $pacienteID, $fecha, $cantidad);

            /* $valores = explode(' ', $fecha);
            $dia = $valores[1];
            $hora = $valores[2];

            $valores = explode('-', $dia);
            $fecha = "20".$valores[2]."-".; */

            $aux =obtenerRecursoAsignadosByPaciente_Recurso($pacienteID, $recurso->id);

            if($aux == null)
            {
                if(insertarRecursoAsignado($recursoA))
                {
                    $cantidadAux = (int)$recurso->cantidad - (int)$cantidad;
                    $recurso->cantidad = $cantidadAux;
                    updateRecurso($recurso);
                    header("Location: paciente.php?id=".$pacienteID);
                }
                else
                {
                    $_SESSION['errCantidad'] = "Error al Asignar el Recurso!";
                    header("Location: asignarR.php?id=".$pacienteID);
                }
            }
            else
            {
                $cantidadAux = (int)$aux->cantidad + (int)$cantidad;
                $recursoA->cantidad = $cantidadAux;
                if(updateRecursoAsignado($recursoA))
                {
                    $cantidadAux = (int)$recurso->cantidad - (int)$cantidad;
                    $recurso->cantidad = $cantidadAux;
                    updateRecurso($recurso);
                    header("Location: paciente.php?id=".$pacienteID);
                }
                else
                {
                    $_SESSION['errCantidad'] = "Error al Asignar el Recurso!";
                    header("Location: asignarR.php?id=".$pacienteID);
                }
            }
            
        }
    }

?>