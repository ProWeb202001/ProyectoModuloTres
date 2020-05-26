<?php
    class Usuario
    {
        var $nombreUsuario;
        var $email;
        var $password;
        var $rol;
        
        function __construct($nombre, $correo, $contraseña,$rol)
        {
            $this->nombreUsuario = $nombre;
            $this->email = $correo;
            $this->password = $contraseña;
            $this->rol = $rol;
        }


    }
?>