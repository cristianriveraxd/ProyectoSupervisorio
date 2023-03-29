<?php
//Autor: Cristian Rivera. 13/03/23
//Proyecto supervisorio sistema de paletizado.
//Hoja de conexión a BD.
class Conexion{
    
    public static $conn;

    //credenciales y conexión en si
    static function conexionBD()
    {

        //Conexión a BD
        $localhost = 'SERVERDORIA-WCS';
        $dbname = 'BDPASTADORIA';
        $username = 'CristianRivera';
        $password = 'Doria_2022+';
        $puerto = '1433';

        //VALIDACIÓN DE PUERTO EN MSSQLSERVER
        //inicio, instalación de mssqlserver, administrador y  configuración, protocolos de SQLEXPRESS,
        //TCP/IP,direccionesIP,puertodinamicoTCP (estadeultimo).

        try {
            //leer sobre PDO
            self::$conn = new PDO("sqlsrv:Server=$localhost,$puerto;Database=$dbname", $username, $password);
            //Validación de conexión
            //echo ("Se conecto correctamente a la base de datos");
        } catch (PDOException $e) {
            //echo ("No se logro conectar correctamente con la base de datos: $dbname, error: $e");
        }

        return self::$conn;
    }

}

?>