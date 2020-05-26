<?php
    class Usuario
    {
        var $id;
        var $nombreUsuario;
        var $email;
        var $password;
        var $rol;
        
        function __construct($id,$nombre, $correo, $contraseña,$rol)
        {
            $this->id = $id;
            $this->nombreUsuario = $nombre;
            $this->email = $correo;
            $this->password = $contraseña;
            $this->rol = $rol;
        }

    }
?>