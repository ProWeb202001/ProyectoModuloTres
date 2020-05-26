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
        mysqli_close($con);
        return mysqli_fetch_array($resultado);
    }

    function consultarUsuarioById($id)
    {
        $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);
        $sql = "SELECT * FROM Usuarios Where UserID='$id'";
        $resultado = mysqli_query($con, $sql);
        mysqli_close($con);
        return mysqli_fetch_array($resultado);
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

?>