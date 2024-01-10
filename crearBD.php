<?php

/* Ejecutando este fichero crearemos la BD en nuestro servidor de BD.
 Los datos de conexión son los siguientes, comprueba que coinciden con los tuyos, sino no funcionará.
 Los leeremos de config.php
 $db_hostname = "localhost";
 $db_nombre = "usuarios";
 $db_usuario = "root";
 $db_clave = "";
*/

//En config.php tenemos los valores de conexión a la BD
require('app/libs/config.php');
try {
    /*
    Conectamos
    No le pasamos nombre de BD porque vamos a crearla
    */
    $pdo = new PDO('mysql:host=' . DB_HOSTNAME, DB_USUARIO, DB_CLAVE);
    //UTF8  
    $pdo->exec("set names utf8");
    // Accionamos el uso de excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Leemos el fichero que contiene el sql
    $sqlBD = file_get_contents("evaluable_7w.sql");
    //Ejecutamos la consulta
    $pdo->exec($sqlBD);
    echo ("La BD ha sido creada");
    //Cerramos conexion
    $pdo = null;
} catch (PDOException $e) {
    // En este caso guardamos los errores en un archivo de errores log
    error_log($e->getMessage() . "## Fichero: " . $e->getFile() . "## Línea: " . $e->getLine() . "##Código: " . $e->getCode() . "##Instante: " . microtime() . PHP_EOL, 3, "logBD.txt");
    // guardamos en ·errores el error que queremos mostrar a los usuarios
    $errores['datos'] = "Ha habido un error <br>";
}
