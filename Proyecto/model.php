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

    class Habitacion
    {
        var $id;
        var $numero;
        
        function __construct($id,$numero)
        {
            $this->id = $id;
            $this->numero = $numero;
        }
    }

    class Camas
    {
        var $id;
        var $numero;
        var $habID;
        
        function __construct($id,$numero,$habID)
        {
            $this->id = $id;
            $this->numero = $numero;
            $this->habID = $habID;
        }
    }

    class Paciente
    {
        var $pid;
        var $identificacion;
        var $nombre;
        var $diagnostico;
        var $prioridad;
        var $fechaIngreso;
        var $duracionDias;
        var $camaID;
        var $medicoID;

        function __construct($pid,$identificacion,$nombre,$diagnostico,$prioridad,$fechaIngreso,$duracionDias,$camaID,$medicoID)
        {
            $this->pid = $pid;
            $this->identificacion = $identificacion;
            $this->nombre = $nombre;
            $this->diagnostico = $diagnostico;
            $this->prioridad = $prioridad;
            $this->fechaIngreso = $fechaIngreso;
            $this->duracionDias = $duracionDias;
            $this->camaID = $camaID;
            $this->medicoID = $medicoID;
        }
    }
<<<<<<< HEAD
    class EquipoAsigando
    {
        var $id;
        var $equipoID;
        var $nombre; 
        var $pacienteID;
        var $fechaPedido;
        var $cantidad;
        
        function __construct($id,$equipoID, $pacienteID, $fechaPedido,$cantidad,$nombre)
        {
            $this->id = $id;
            $this->equipoID = $equipoID;
            $this->pacienteID = $pacienteID;
            $this->fechaPedido = $fechaPedido;
            $this->cantidad = $cantidad;
            $this->nombre = $nombre;
        }
    }
=======
>>>>>>> 61c7ea713cd95461eec895891830a53a8de0e2d2
?>