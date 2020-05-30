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
        $CamaID = (int)$_POST['CamaID'];
        $MedicoID = (int)$_POST['MedicoID'];

        if(empty($_POST['Identificacion']))
        {
            $_SESSION['errIdentificacion']="La identificación es obligatoria !";
            $error = true;
        }
        else
        {
            $identificacion = limpiar_entrada($_POST['Identificacion']);
            $_SESSION['identificacion'] = $identificacion;
            if (!preg_match("/^[0-9]+$/",$identificacion))
            {
                $_SESSION['errIdentificacion'] = "Solo números!";
                $error = true;
            }
            else
            {

                $aux = consultarPaciente($identificacion);
                if($aux != null)
                {
                    $_SESSION['errIdentificacion'] = "Ya existe un Paciente con esta Identificación !";
                    $error = true;
                }
            }
        }

        if(empty($_POST['Nombre']))
        {
            $_SESSION['errNombre']="El nombre es obligatorio !";
            $error = true;
        }
        else
        {
            $nombre = limpiar_entrada($_POST['Nombre']);
            $_SESSION['nombre'] = $nombre;
            if (!preg_match("/^[a-zA-Z ]+$/",$nombre))
            {
                $_SESSION['errNombre'] = "Solo letras y espacios !";
                $error = true;
            }
        }

        if(empty($_POST['Diagnostico']))
        {
            $_SESSION['errDiagnostico']="El Diagnostico es obligatorio !";
            $error = true;
        }
        else
        {
            $diagnostico = limpiar_entrada($_POST['Diagnostico']);
            $_SESSION['diagnostico'] = $diagnostico;
        }

        if(empty($_POST['Prioridad']))
        {
            $_SESSION['errPrioridad']="La prioridad es obligatoria !";
            $error = true;
        }
        else
        {
            $prioridad = limpiar_entrada($_POST['Prioridad']);
            $_SESSION['prioridad'] = $prioridad;
        }

        if(empty($_POST['FechaIngreso']))
        {
            $_SESSION['errFechaIngreso']="La Fecha de Ingreso es obligatoria !";
            $error = true;
        }
        else
        {
            $fechaIngreso = limpiar_entrada($_POST['FechaIngreso']);
            $_SESSION['fechaIngreso'] = $fechaIngreso;
            if (!preg_match("/^[0-9]?[0-9]\/[0-9]?[0-9]\/[1-2][0-9][0-9][0-9]$/",$fechaIngreso))
            {
                $_SESSION['errFechaIngreso'] = "El formato de la fecha es dd/mm/aaaa, donde d (dia), m (mes) y a (año) son números !";
                $error = true;
            }
            else
            {
                $valores = explode('/', $fechaIngreso);

                if(!checkdate($valores[1], $valores[0], $valores[2]))
                {
                    $_SESSION['errFechaIngreso'] = "La fecha ingresada no existe !";
                    $error = true;
                }
            }
        }

        if(empty($_POST['DuracionDias']))
        {
            $_SESSION['errDuracionDias']="La Duracion en Dias es obligatoria !";
            $error = true;
        }
        else
        {
            $duracionDias = limpiar_entrada($_POST['DuracionDias']);
            $_SESSION['duracionDias'] = $duracionDias;
            if (!preg_match("/^[1-9][0-9]*$/",$duracionDias))
            {
                $_SESSION['errDuracionDias'] = "La Duracion en Dias debe ser solo números !";
                $error = true;
            }
        }
        
        if($error == true)
        {
            header("Location: agregarPaciente.php?id=".$CamaID);
        }
        else
        {
            eliminarSessionV('identificacion');
            eliminarSessionV('nombre');
            eliminarSessionV('diagnostico');
            eliminarSessionV('prioridad');
            eliminarSessionV('fechaIngreso');
            eliminarSessionV('duracionDias');

            $paciente = new Paciente(null, $identificacion, $nombre, $diagnostico, $prioridad, $fechaIngreso, $duracionDias, $CamaID, $MedicoID);

            if(insertarPaciente($paciente))
            {
                header("Location: listarHabitaciones.php");
            }
            else
            {
                $_SESSION['errIdentificacion'] = "Error al crear el paciente!";
                header("Location: agregarPaciente.php?id=".$CamaID);
            }
        }
    }

?>