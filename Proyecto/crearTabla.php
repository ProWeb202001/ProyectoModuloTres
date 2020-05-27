<?php

    //incluir archivo de configuración con usuario y contraseña
    //dirname: misma carpeta donde estoy
    include_once 'config.php';
    include_once 'model.php';
    include_once 'utils.php';

    //crear Conexión
    //Variables en archivo config
    $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS,NOMBRE_DB);

    if(mysqli_connect_errno())
    {
        echo "Error en la conexión: ". mysqli_connect_error();
    }
    else
    {
        $sql = "CREATE TABLE Usuarios(
            UserID INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(UserID),
            NombreUsuario CHAR(30) NOT NULL UNIQUE,
            Rol Char(30) NOT NULL,
            Email Char(30) NOT NULL,
            Contraseña CHAR(200) NOT NULL)";
        /* $sql = "DROP TABLE Usuarios"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Usuarios creada correctamente<br><br>";
            $usuario = new Usuario('Admin', 'proweb202001@gmail.com','holamundo','admin');
            if(insertarUsuario($usuario))
            {
                echo "Usuario Admin Insertado";
            }
            else
            {
                echo "Error en la inserción " . mysqli_error($con)."<br><br>";
            }

        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Habitaciones(
            ID INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(ID),
            Numero INT NOT NULL)";
        /* $sql = "DROP TABLE Habitaciones"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Habitaciones creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Camas(
            ID INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(ID),
            Numero INT NOT NULL,
            HabitacionID INT NOT NULL,
            FOREIGN KEY (HabitacionID) REFERENCES Habitaciones(ID)
            )";
        /* $sql = "DROP TABLE Camas"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Camas creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Pacientes(
            PID INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(PID),
            Identificacion INT NOT NULL,
            Nombre CHAR(30) NOT NULL,    
            Diagnostico CHAR(255) NOT NULL,
            Prioridad CHAR(5) NOT NULL,
            FechaIngreso DATE NOT NULL,
            DuracionDias INT NOT NULL,
            CamaID INT NOT NULL,
            FOREIGN KEY (CamaID) REFERENCES Camas(ID),
            MedicoID INT NOT NULL,
            FOREIGN KEY (MedicoID) REFERENCES Usuarios(UserID)
            )";
        /* $sql = "DROP TABLE Pacientes"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Pacientes creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Recursos(
            ID INT NOT NULL AUTO_INCREMENT, 
            PRIMARY KEY(ID),
            Nombre CHAR(30) NOT NULL,
            Cantidad INT NOT NULL Default 0
            )";
        /* $sql = "DROP TABLE Recursos"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Recursos creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Recursos_Asignados(
            PacienteID INT NOT NULL,
            FOREIGN KEY (PacienteID) REFERENCES Pacientes(PID),
            RecursoID INT NOT NULL,
            FOREIGN KEY (RecursoID) REFERENCES Recursos(ID),
            Cantidad INT NOT NULL,
            FechaPedido DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
        /* $sql = "DROP TABLE Recursos_Asignados"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Recursos_Asignados creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Equipos(
            ID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(ID),
            Nombre CHAR(30) NOT NULL,
            Cantidad INT NOT NULL
            )";
        /* $sql = "DROP TABLE Equipos"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Equipos creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Mensajes_Admin(
            ID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(ID),
            EquipoID INT NOT NULL,
            FOREIGN KEY (EquipoID) REFERENCES Equipos(ID),
            PacienteID INT NOT NULL,
            FOREIGN KEY (PacienteID) REFERENCES Pacientes(PID),
            FechaPedido DATETIME,
            Cantidad INT NOT NULL
            )";
        /* $sql = "DROP TABLE Mensajes_Admin"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Mensajes_Admin creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

        $sql = "CREATE TABLE Equipos_Asignados(
            ID INT NOT NULL AUTO_INCREMENT,
            PRIMARY KEY(ID),
            EquipoID INT NOT NULL,
            FOREIGN KEY (EquipoID) REFERENCES Equipos(ID),
            PacienteID INT NOT NULL,
            FOREIGN KEY (PacienteID) REFERENCES Pacientes(PID),
            FechaPedido DATETIME,
            Cantidad INT NOT NULL
            )";
        /* $sql = "DROP TABLE Equipos_Asignados"; */
        if(mysqli_query($con, $sql))
        {
            echo "Tabla Equipos_Asignados creada correctamente<br><br>";
        }
        else
        {
            echo "Error en la creacion " . mysqli_error($con)."<br><br>";
        }

    }
    mysqli_close($con);

?>