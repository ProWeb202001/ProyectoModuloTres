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
        $usuario = new Usuario($user['UserID'],$user['NombreUsuario'],$user['Email'], $user['Contraseña'], $user['Rol']);
        mysqli_close($con);
        return $usuario;
    }

    function consultarUsuarioById($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Usuarios Where UserID='$id'";
        $resultado = mysqli_query($con, $sql);
        $user = mysqli_fetch_array($resultado);
        $usuario = new Usuario($user['UserID'],$user['NombreUsuario'],$user['Email'], $user['Contraseña'], $user['Rol']);
        mysqli_close($con);
        return $usuario;
    }

    function updateUsuario($usuario)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $bandera = false;
        $sql = "UPDATE Usuarios SET NombreUsuario='{$usuario->nombreUsuario}', Email = '{$usuario->email}', Contraseña = '{$usuario->password}', Rol = '{$usuario->rol}'  WHERE UserID = '{$usuario->id}';";
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

?>