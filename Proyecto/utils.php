<?php
    include_once 'model.php';
    include_once 'config.php';

    function eliminarSessionV($s)
    {
        if(isset($_SESSION[$s]))
        {
            unset($_SESSION[$s]);
        }
    }

    function limpiar_entrada($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function consultarUsuario($nombreUsuario)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Usuarios Where NombreUsuario='$nombreUsuario'";
        $resultado = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($resultado);
        if($user!=null)
        {
            $usuario = new Usuario($user['UserID'],$user['NombreUsuario'],$user['Email'], $user['Contraseña'], $user['Rol']);
        }
        else
        {
            $usuario = null;
        }
        mysqli_close($con);
        
        return $usuario;
    }

    function consultarUsuarioById($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Usuarios Where UserID='$id'";
        $resultado = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($resultado);
        if($user!=null)
        {
            $usuario = new Usuario($user['UserID'],$user['NombreUsuario'],$user['Email'], $user['Contraseña'], $user['Rol']);
        }
        else
        {
            $usuario = null;
        }
        mysqli_close($con);
        return $usuario;
    }

    function updateUsuario($usuario)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $bandera = false;
        $sql = "UPDATE Usuarios SET NombreUsuario='{$usuario->nombreUsuario}', Email = '{$usuario->email}', Rol = '{$usuario->rol}'  WHERE UserID = '{$usuario->id}';";
        if(mysqli_query($con, $sql))
        {
            $bandera= true;
        }
        mysqli_close($con);
        return $bandera;
    }

    function insertarUsuario($usuario)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $contraseña = encriptar($usuario->password);
        $sql = "INSERT INTO Usuarios (NombreUsuario,Rol,Email,Contraseña) VALUES ('$usuario->nombreUsuario', '$usuario->rol', '$usuario->email','$contraseña')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
    }

    function encriptar($password)
    {
        return crypt($password, '$6$rounds=5000$usesomesillystringforsaltforexamplelapujamijo$');
    }

    function compararPassword($p1, $p2)
    {
        return hash_equals($p1, crypt($p2, $p1));
    }

    /**
     * -----------------------------------------------------------------------
     * 
     * Métodos para los medicos
     * 
     * -----------------------------------------------------------------------
     */
    function consultarMedicoByID($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM usuarios Where UserID='$id'";
        $resultado = mysqli_query($con, $sql);
        $medico = mysqli_fetch_array($resultado);
        if($medico!=null)
        {
            $medico = new Usuario($medico['UserID'],$medico['NombreUsuario'],'','','');
        }
        else
        {
            $medico = null;
        }
        mysqli_close($con);
        return $medico; 
        
    }
    function obtenerMedicos()
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Usuarios WHERE Rol = 'medico'";

        $resultado = mysqli_query($con, $sql);
        $medicos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $medico = new Usuario($fila['UserID'],$fila['NombreUsuario'],$fila['Email'], null, null);
            $medicos[$i] = $medico;
            $i += 1;
        }
        mysqli_close($con);
        return $medicos;
    }

    function obtenerHabitaciones()
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Habitaciones";

        $resultado = mysqli_query($con, $sql);
        $habitaciones=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $habitacion = new Habitacion($fila['ID'], $fila['Numero']);
            $habitaciones[$i] = $habitacion;
            $i += 1;
        }
        mysqli_close($con);
        return $habitaciones;
    }

    function insertarHabitacion($habitacion)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "INSERT INTO Habitaciones (Numero) VALUES ('$habitacion->numero')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
    }

    function consultarHabitacion($numero)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Habitaciones Where Numero='$numero'";
        $resultado = mysqli_query($con, $sql);
        $hab = mysqli_fetch_array($resultado);
        if($hab!=null)
        {
            $habitacion = new Habitacion($hab['ID'],$hab['Numero']);
        }
        else
        {
            $habitacion = null;
        }
        mysqli_close($con);
        
        return $habitacion;
    }

    function consultarHabitacionByID($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Habitaciones Where ID='$id'";
        $resultado = mysqli_query($con, $sql);
        $hab = mysqli_fetch_array($resultado);
        if($hab!=null)
        {
            $habitacion = new Habitacion($hab['ID'],$hab['Numero']);
        }
        else
        {
            $habitacion = null;
        }
        mysqli_close($con);
        
        return $habitacion;
    }

    function obtenerCamasHabitacion($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Camas Where HabitacionID='$id'";
        $resultado = mysqli_query($con, $sql);
        $camas = array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $cama = new Camas($fila['ID'],$fila['Numero'],$fila['HabitacionID']);
            $camas[$i] = $cama;
            $i += 1;
        }
        mysqli_close($con);
        return $camas;
    }
    
    function consultarCamaH($numero,$habID)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Camas Where Numero='$numero'AND HabitacionID='$habID'";
        $resultado = mysqli_query($con, $sql);
        $cama = mysqli_fetch_array($resultado);
        if($cama!=null)
        {
            $cama = new Camas($cama['ID'],$cama['Numero'],$cama['HabitacionID']);
        }
        else
        {
            $cama = null;
        }
        mysqli_close($con);
        
        return $cama;
    }
    function obtenerHabitacionesDisponibles()
    {
        $habitaciones = obtenerHabitaciones();

        $habitacionesDisp = array();
        $i=0;
        foreach($habitaciones as $h)
        {
            $camas = obtenerCamasDisponiblesByHabID($h->id);
            if(count($camas)>0)
            {
                $habitacionesDisp[$i] = $h;
                $i += 1;
            }
        }

        return $habitacionesDisp;
    }

    function obtenerCamasDisponiblesByHabID($id)
    {
        $camas = obtenerCamasHabitacion($id);
        $pacientes = obtenerPacientes();

        $i = 0;

        $camasDisponibles = array();

        foreach($camas as $c)
        {
            $bandera = false;
            foreach($pacientes as $p)
            {
                if($p->camaID == $c->id)
                {
                    $bandera = true;
                }
            }
            if($bandera == false)
            {
                $camasDisponibles[$i]= $c;
                $i += 1;
            }
        }
        return $camasDisponibles;
    }

     /**
     * -----------------------------------------------------------------------
     * 
     * Métodos para las camas
     * 
     * -----------------------------------------------------------------------
     */
    function consultarCama($numero)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Camas Where Numero='$numero'";
        $resultado = mysqli_query($con, $sql);
        $cama = mysqli_fetch_array($resultado);
        if($cama!=null)
        {
            $cama = new Camas($cama['ID'],$cama['Numero'],$cama['HabitacionID']);
        }
        else
        {
            $cama = null;
        }
        mysqli_close($con);
        
        return $cama;
    }
    
    function consultarCamaByID($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Camas Where ID='$id'";
        $resultado = mysqli_query($con, $sql);
        $cama = mysqli_fetch_array($resultado);
        if($cama!=null)
        {
            $cama = new Camas($cama['ID'],$cama['Numero'],$cama['HabitacionID']);
        }
        else
        {
            $cama = null;
        }
        mysqli_close($con);
        
        return $cama;
    }

    function insertarCama($cama)
    {
        $bandera = false;
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $idHab = 0;
        $idHab = (int)$cama->habID;
        $sql = "INSERT INTO Camas (Numero,HabitacionID) VALUES ('$cama->numero', '$idHab')";
        if(mysqli_query($con, $sql))
        {
            $bandera = true;
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
            $bandera= false;
        }
        mysqli_close($con);

        return $bandera;
    }


    
    
    /**
     * -----------------------------------------------------------------------
     * 
     * Metodos para Pacientes
     * 
     * -----------------------------------------------------------------------
     */
    function obtenerPacientes()
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Pacientes";

        $resultado = mysqli_query($con, $sql);
        $personas=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $persona = new Paciente($fila['PID'],$fila['Identificacion'],$fila['Nombre'],$fila['Diagnostico'],$fila['Prioridad'],$fila['FechaIngreso'],$fila['DuracionDias'],$fila['CamaID'],$fila['MedicoID']);
            $personas[$i] = $persona;
            $i += 1;
        }
        mysqli_close($con);
        return $personas;
    }
    
    function obtenerPacientesDisponibles_Equipos($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Pacientes";

        $resultado = mysqli_query($con, $sql);
        $personas=array();
        $bandera = 0;   
        $i = 0; 
        while($fila = mysqli_fetch_array($resultado))
        {
            $persona = new Paciente($fila['PID'],$fila['Identificacion'],$fila['Nombre'],$fila['Diagnostico'],$fila['Prioridad'],$fila['FechaIngreso'],$fila['DuracionDias'],$fila['CamaID'],$fila['MedicoID']);
            $equipoA = obtenerEquiposAsignadosByID($persona->pid);
            $mensajes = obtenerMensajesByPaciente($persona->pid); 
            $cantidad = count($equipoA); 
            $cantidad2 = count($mensajes); 
            if($persona->prioridad =="Alta" && ($cantidad + $cantidad2) < 3)
            {
                $bandera= 1; 
            }
            else if($persona->prioridad =="Media" &&  ($cantidad + $cantidad2) < 2)
            {
                $bandera= 1; 
            }
            else if($persona->prioridad =="Baja" &&  ($cantidad + $cantidad2) < 1)
            {
                $bandera= 1; 
            }
            if($bandera == 1)
            {
                if($persona->pid != $id)
                {
                    $personas[$i] = $persona;
                    $i += 1;
                }
                
            }
        }


        mysqli_close($con);
        return $personas;
    }
    function obtenerPacientesByMedico($medicoID)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Pacientes Where medicoID='$medicoID'";
        $resultado = mysqli_query($con, $sql);
        $personas=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $persona = new Paciente($fila['PID'],$fila['Identificacion'],$fila['Nombre'],$fila['Diagnostico'],$fila['Prioridad'],$fila['FechaIngreso'],$fila['DuracionDias'],$fila['CamaID'],$fila['MedicoID']);
            $personas[$i] = $persona;
            $i += 1;
        }
        mysqli_close($con);
        return $personas;
    }

    function consultarPaciente($identificacion)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Pacientes Where Identificacion='$identificacion'";
        $resultado = mysqli_query($con, $sql);
        $paciente = mysqli_fetch_array($resultado);
        if($paciente!=null)
        {
            $paciente = new Paciente($paciente['PID'],$paciente['Identificacion'],$paciente['Nombre'],$paciente['Diagnostico'], $paciente['Prioridad'],$paciente['FechaIngreso'],$paciente['DuracionDias'],$paciente['CamaID'],$paciente['MedicoID']);
        }
        else
        {
            $paciente = null;
        }
        mysqli_close($con);
        
        return $paciente;
    }

    function consultarPacienteByID($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Pacientes Where PID='$id'";
        $resultado = mysqli_query($con, $sql);
        $paciente = mysqli_fetch_array($resultado);
        if($paciente!=null)
        {
            $paciente = new Paciente($paciente['PID'],$paciente['Identificacion'],$paciente['Nombre'],$paciente['Diagnostico'], $paciente['Prioridad'],$paciente['FechaIngreso'],$paciente['DuracionDias'],$paciente['CamaID'],$paciente['MedicoID']);
        }
        else
        {
            $paciente = null;
        }
        mysqli_close($con);
        
        return $paciente;
    }

    function insertarPaciente($paciente)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $fecha = $paciente->fechaIngreso;
        $valores = explode('/', $fecha);

        $fecha = $valores[2]."-".$valores[1]."-".$valores[0];

        $sql = "INSERT INTO Pacientes (Identificacion, Nombre, Diagnostico, Prioridad, FechaIngreso, DuracionDias, CamaID, MedicoID) 
                VALUES ('$paciente->identificacion', '$paciente->nombre','$paciente->diagnostico','$paciente->prioridad','$fecha','$paciente->duracionDias','$paciente->camaID','$paciente->medicoID')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
    }
    /**
     * -----------------------------------------------------------------------
     * 
     * Metodos para Pacientes
     * 
     * -----------------------------------------------------------------------
     */
    function obtenerEquiposByPaciente($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT equipos_asignados.ID,EquipoID,PacienteID,FechaPedido,equipos_asignados.Cantidad,Nombre 
        FROM equipos_asignados 
        INNER JOIN equipos ON 
        equipos_asignados.EquipoID=equipos.ID
        Where PacienteID='$id'";
        $resultado = mysqli_query($con, $sql);
        $equipos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $equipo = new EquipoAsignado($fila['ID'],$fila['EquipoID'],$fila['PacienteID'],$fila['FechaPedido'],$fila['Cantidad'],$fila['Nombre']); 
            $equipos[$i] = $equipo;
            $i += 1;
        }
        mysqli_close($con);
        return $equipos;
    }

    /**
     * -----------------------------------------------------------------------
     * 
     * Metodos para Recursos
     * 
     * -----------------------------------------------------------------------
     */
    
     function obtenerRecursos()
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Recursos ORDER BY Cantidad ASC";

        $resultado = mysqli_query($con, $sql);
        $recursos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $recurso = new Recursos($fila['ID'], $fila['Nombre'], $fila['Cantidad']);
            $recursos[$i] = $recurso;
            $i += 1;
        }
        mysqli_close($con);
        return $recursos;
     }

     function consultarRecurso($nombre)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Recursos WHERE Nombre='$nombre'";

        $resultado = mysqli_query($con, $sql);
        $recurso = mysqli_fetch_array($resultado);
        if($recurso!=null)
        {
            $recurso = new Recursos($recurso['ID'],$recurso['Nombre'],$recurso['Cantidad']);
        }
        else
        {
            $recurso = null;
        }
        mysqli_close($con);
        return $recurso;
     }

     function consultarRecursoByID($id)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Recursos WHERE ID='$id'";

        $resultado = mysqli_query($con, $sql);
        $recurso = mysqli_fetch_array($resultado);
        if($recurso!=null)
        {
            $recurso = new Recursos($recurso['ID'],$recurso['Nombre'],$recurso['Cantidad']);
        }
        else
        {
            $recurso = null;
        }
        mysqli_close($con);
        return $recurso;
     }

     function insertarRecurso($rec)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "INSERT INTO Recursos (Nombre, Cantidad) VALUES ('$rec->nombre', '$rec->cantidad')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
     }

     

     function obtenerRecursosDisponibles()
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Recursos WHERE Cantidad>0 ORDER BY Cantidad ASC";

        $resultado = mysqli_query($con, $sql);
        $recursos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $recurso = new Recursos($fila['ID'], $fila['Nombre'], $fila['Cantidad']);
            $recursos[$i] = $recurso;
            $i += 1;
        }
        mysqli_close($con);
        return $recursos;
     }

    function updateRecurso($rec)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $bandera = false;
        $sql = "UPDATE Recursos SET Cantidad='$rec->cantidad'  WHERE ID = '$rec->id';";
        if(mysqli_query($con, $sql))
        {
            $bandera= true;
        }
        mysqli_close($con);
        return $bandera;
    }

      /**
     * -----------------------------------------------------------------------
     * 
     * Metodos para Recursos Asignados
     * 
     * -----------------------------------------------------------------------
     */

     function obtenerRecursosAsignadosByPaciente($id)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Recursos_Asignados WHERE PacienteID ='$id'";

        $resultado = mysqli_query($con, $sql);
        $recursosA=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $idPaciente = $fila['PacienteID'];
            $idRecurso = $fila['RecursoID'];
            $recursoA = new Recursos_Asignados($idRecurso, $idPaciente, $fila['FechaPedido'],$fila['Cantidad']);
            $recursosA[$i] = $recursoA;
            $i += 1;
        }
        mysqli_close($con);
        return $recursosA;
     }

     function obtenerRecursoAsignadosByPaciente_Recurso($Pid, $Rid)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Recursos_Asignados WHERE PacienteID ='$Pid' and RecursoID ='$Rid'";

        $resultado = mysqli_query($con, $sql);
        $recursoA = mysqli_fetch_array($resultado);
        if($recursoA!=null)
        {
            $recursoA = new Recursos_Asignados($recursoA['RecursoID'], $recursoA['PacienteID'], $recursoA['FechaPedido'],$recursoA['Cantidad']);
        }
        else
        {
            $recursoA = null;
        }
        mysqli_close($con);
        return $recursoA;
     }

     function insertarRecursoAsignado($recursoA)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "INSERT INTO Recursos_Asignados VALUES ('$recursoA->pacienteID', '$recursoA->recursoID', '$recursoA->cantidad', '$recursoA->FechaPedido')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
     }

     function updateRecursoAsignado($rec)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $bandera = false;
        $sql = "UPDATE Recursos_Asignados SET FechaPedido='$rec->FechaPedido' ,Cantidad=$rec->cantidad  WHERE PacienteID = '$rec->pacienteID' and RecursoID = '$rec->recursoID';";
        if(mysqli_query($con, $sql))
        {
            $bandera= true;
        }
        mysqli_close($con);
        return $bandera;
    }

      /**
     * -----------------------------------------------------------------------
     * 
     * Metodos para Equipos
     * 
     * -----------------------------------------------------------------------
     */
    function obtenerEquiposDisponibles()
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Equipos WHERE Cantidad>0 ORDER BY Cantidad ASC";

        $resultado = mysqli_query($con, $sql);
        $equipos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $equipo = new Equipos($fila['ID'], $fila['Nombre'], $fila['Cantidad']);
            $equipos[$i] = $equipo;
            $i += 1;
        }
        mysqli_close($con);
        return $equipos;
     }
     function consultarEquipo($nombre)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Equipos WHERE Nombre='$nombre'";

        $resultado = mysqli_query($con, $sql);
        $equipo = mysqli_fetch_array($resultado);
        if($equipo!=null)
        {
            $equipo = new Recursos($equipo['ID'],$equipo['Nombre'],$equipo['Cantidad']);
        }
        else
        {
            $equipo = null;
        }
        mysqli_close($con);
        return $equipo;
     }

     function consultarEquipoByID($id)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Equipos WHERE ID='$id'";

        $resultado = mysqli_query($con, $sql);
        $equipo = mysqli_fetch_array($resultado);
        if($equipo!=null)
        {
            $equipo = new Equipos($equipo['ID'],$equipo['Nombre'],$equipo['Cantidad']);
        }
        else
        {
            $equipo = null;
        }
        mysqli_close($con);
        return $equipo;
     }

     function consultarEquipoAsignadoByID($id)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT equipos_asignados.ID,EquipoID,PacienteID,FechaPedido,equipos_asignados.Cantidad,Nombre 
        FROM equipos_asignados 
        INNER JOIN equipos ON 
        equipos_asignados.EquipoID=equipos.ID
        WHERE equipos_asignados.ID='$id'";

        $resultado = mysqli_query($con, $sql);
        $equipo = mysqli_fetch_array($resultado);
        if($equipo!=null)
        {
            $equipo = new EquipoAsignado($equipo['ID'],$equipo['EquipoID'],$equipo['PacienteID'],$equipo['FechaPedido'], $equipo['Cantidad'],$equipo['Nombre']);
        }
        else
        {
            $equipo = null;
        }
        mysqli_close($con);
        return $equipo;
     }
     function obtenerEquipoAsignadosByPaciente_Equipo($Pid, $Eid)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Equipos_Asignados WHERE PacienteID ='$Pid' and EquipoID ='$Eid'";

        $resultado = mysqli_query($con, $sql);
        $equipoA = mysqli_fetch_array($resultado);
        if($equipoA!=null)
        {
            $equipoA = new EquipoAsignado($equipoA['ID'],$equipoA['EquipoID'], $equipoA['PacienteID'], $equipoA['FechaPedido'],$equipoA['Cantidad'], null);
        }
        else
        {
            $equipoA = null;
        }
        mysqli_close($con);
        return $equipoA;
     }

     function obtenerMensajesByEquipoPaciente($Pid, $Eid)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Mensajes_admin WHERE PacienteID ='$Pid' and EquipoID ='$Eid'";

        $resultado = mysqli_query($con, $sql);
        $equipoA = mysqli_fetch_array($resultado);
        if($equipoA!=null)
        {
            $equipoA = new EquipoAsignado($equipoA['ID'],$equipoA['EquipoID'], $equipoA['PacienteID'], $equipoA['FechaPedido'],$equipoA['Cantidad'], null);
        }
        else
        {
            $equipoA = null;
        }
        mysqli_close($con);
        return $equipoA;
     }
     

     function insertarMensaje($mensaje)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "INSERT INTO mensajes_admin (EquipoID, PacienteID, FechaPedido, Cantidad) VALUES ('$mensaje->equipoID', '$mensaje->pacienteID', '$mensaje->fechaPedido', '$mensaje->cantidad')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
     }

     function obtenerMensajesByPaciente($Pid)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Mensajes_admin WHERE PacienteID ='$Pid'";

        $resultado = mysqli_query($con, $sql);
        $equipos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $equipoA = new EquipoAsignado($fila['ID'],$fila['EquipoID'], $fila['PacienteID'], $fila['FechaPedido'],$fila['Cantidad'], null);
            $equipos[$i] = $equipoA;
            $i += 1;
        }
        mysqli_close($con);
        return $equipos;
     }

    function obtenerEquiposAsignados()
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT equipos_asignados.ID,EquipoID,PacienteID,FechaPedido,equipos_asignados.Cantidad,Nombre 
        FROM equipos_asignados 
        INNER JOIN equipos ON 
        equipos_asignados.EquipoID=equipos.ID";
        $resultado = mysqli_query($con, $sql);
        $equipos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $equipo = new EquipoAsignado($fila['ID'],$fila['EquipoID'],$fila['PacienteID'],$fila['FechaPedido'],$fila['Cantidad'],$fila['Nombre']); 
            $equipos[$i] = $equipo;
            $i += 1;
        }
        mysqli_close($con);
        return $equipos;
    }
     function insertarEquipo($rec)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "INSERT INTO Equipos (Nombre, Cantidad) VALUES ('$rec->nombre', '$rec->cantidad')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
     }
    function updateEquipo($rec)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $bandera = false;
        $sql = "UPDATE Equipos SET Cantidad='$rec->cantidad'  WHERE ID = '$rec->id';";
        if(mysqli_query($con, $sql))
        {
            $bandera= true;
        }
        mysqli_close($con);
        return $bandera;
    }
    function updateEquipoAsignado($rec)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $bandera = false;
        $sql = "UPDATE Equipos_Asignados SET PacienteID='$rec->pacienteID'  WHERE ID = '$rec->id'";
        if(mysqli_query($con, $sql))
        {
            $bandera= true;
        }
        mysqli_close($con);
        return $bandera;
    }
    function obtenerEquiposAsignadosByID($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT equipos_asignados.ID,EquipoID,PacienteID,FechaPedido,equipos_asignados.Cantidad,Nombre 
        FROM equipos_asignados 
        INNER JOIN equipos ON 
        equipos_asignados.EquipoID=equipos.ID 
        where equipos_asignados.ID = '$id'";
        $resultado = mysqli_query($con, $sql);
        $equipos=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $equipo = new EquipoAsignado($fila['ID'],$fila['EquipoID'],$fila['PacienteID'],$fila['FechaPedido'],$fila['Cantidad'],$fila['Nombre']); 
            $equipos[$i] = $equipo;
            $i += 1;
        }
        mysqli_close($con);
        return $equipos;
    }
    function obtenerEquipoAsignadoByID($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM equipos_asignados WHERE ID ='$id'";

        $resultado = mysqli_query($con, $sql);
        $equipoA = mysqli_fetch_array($resultado);
        if($equipoA!=null)
        {
            $equipoA = new EquipoAsignado($equipoA['ID'],$equipoA['EquipoID'], $equipoA['PacienteID'], $equipoA['FechaPedido'],$equipoA['Cantidad'], null);
        }
        else
        {
            $equipoA = null;
        }
        mysqli_close($con);
        return $equipoA;
    }

    function obtenerMensajes()
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

            $sql = "SELECT Mensajes_admin.ID,EquipoID,PacienteID,FechaPedido,Mensajes_admin.Cantidad,Nombre 
            FROM Mensajes_admin 
            INNER JOIN equipos ON 
            Mensajes_admin.EquipoID=equipos.ID ORDER BY FechaPedido ASC";

        $resultado = mysqli_query($con, $sql);
        $mensajes=array();
        $i = 0;
        while($fila = mysqli_fetch_array($resultado))
        {
            $mensaje = new EquipoAsignado($fila['ID'],$fila['EquipoID'], $fila['PacienteID'], $fila['FechaPedido'],$fila['Cantidad'], $fila['Nombre']);
            $mensajes[$i] = $mensaje;
            $i += 1;
        }
        mysqli_close($con);
        return $mensajes;
    }

    function ordenarPorPrioridad($mensajes)
    {
        $arreglo = array();
        $alta = array();
        $i = 0;
        $media = array();
        $j = 0;
        $baja = array();
        $k = 0;
        foreach($mensajes as $m)
        {
            $paciente= consultarPacienteByID($m->pacienteID);
            if($paciente->prioridad == "Alta")
            {
                $alta[$i] = $m;
                $i += 1;
            }
            else if($paciente->prioridad == "Media")
            {
                $media[$j] = $m;
                $j += 1;
            }
            else if($paciente->prioridad == "Baja")
            {
                $baja[$k] = $m;
                $k += 1;
            }
        }

        $arreglo = array_merge($alta, $media, $baja);

        return $arreglo;
    }

    function obtenerMensajeByID($id)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "SELECT * FROM Mensajes_admin WHERE ID ='$id'";

        $resultado = mysqli_query($con, $sql);
        $mensaje=mysqli_fetch_array($resultado);
        if($mensaje != null)
        {
            $mensaje = new EquipoAsignado($mensaje['ID'],$mensaje['EquipoID'], $mensaje['PacienteID'], $mensaje['FechaPedido'],$mensaje['Cantidad'], null);
        }
        else
        {
            $mensaje = null;
        }
        mysqli_close($con);
        return $mensaje;
     }

     function eliminarMensaje($mensaje)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $bandera = false;
        $sql = "DELETE FROM mensajes_admin WHERE ID = '$mensaje->id'";
        if(mysqli_query($con, $sql))
        {
            $bandera= true;
        }
        mysqli_close($con);
        return $bandera;
     }

     function insertarEquipoAsignado($recA)
     {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

        $sql = "INSERT INTO equipos_asignados (EquipoID, PacienteID, FechaPedido, Cantidad) VALUES ('$recA->equipoID', '$recA->pacienteID', '$recA->fechaPedido', '$recA->cantidad')";
        if(mysqli_query($con, $sql))
        {
            return true;
        }
        else
        {
            return false;
        }
        mysqli_close($con);
     }

    function enviarCorreo($correo,$asunto,$contenido)
    {

        $header = 'From: '.$correo."\r\n";
        $header .= "X-Mailer: PHP/".phpversion()."\r\n";
        $header .= "Mime-Version: 1.0 \r\n";
        $header = "Content-Type: text/plain";

        return mail($correo, $asunto, $contenido, $header);

    }

?>