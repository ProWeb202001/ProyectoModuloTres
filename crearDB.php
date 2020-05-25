<?php
    //incluir archivo de configuración con usuario y contraseña
    //dirname: misma carpeta donde estoy
    include_once dirname(__FILE__) . '/config.php';

    //crear Conexión
    //Variables en archivo config
    $con = mysqli_connect(HOST_DB,USUARIO_DB,USUARIO_PASS);
    if(mysqli_connect_errno())
    {
        echo "Error en la conexión: ". mysqli_connect_error();
    }
    else
    {
        /* echo "Exito!"; */
        //Crear Base de Datos
        $BD = NOMBRE_DB;
        $sql="CREATE DATABASE $BD";
        if (mysqli_query($con,$sql)) 
        {
            echo "Base de datos $BD creada";
        }
        else 
        {
            echo "Error en la creacion " . mysqli_error($con);
        }
    }
    mysqli_close($con);
?>