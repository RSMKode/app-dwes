<?php
//Libreria de componentes
require("../../../libs/componentes.php");
// Libreria de funciones de validación
require("../../../libs/utils.php");
//De config.php leeremos las variables comunes
require("../../../libs/config.php");

session_start();

cabecera("Usuarios", "../../styles.css");
echo "<h1>Usuarios</h1>";

if (isset($_SESSION["correo"])) {

    echo "<main class='container listaHorizontal'>";

    $archivo = fopen(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "r");
    while (!feof($archivo)) {
        $linea = str_replace("\n", "", fgets($archivo));


        if ($linea != "") {
            $datos = explode("|", $linea);

            $correo = $datos[0];
            $pass = $datos[1];
            $nombre = $datos[2];
            $fechaNacimiento = $datos[3];
            $rutaFoto = $datos[4];
            $idioma = $datos[5];
            $comentario = $datos[6];

            echo "<article class='usuario'>";

            echo "<h1>$nombre</h1>";
            echo "<p>Correo: $correo</p>";
            echo "<p>Pass: $pass</p>";
            echo "<p>Fecha de nacimiento: $fechaNacimiento</p>";
            if ($rutaFoto != "") echo "<img src='$rutaFoto' alt='Imagen de $nombre'>";
            if ($idioma != "") echo "<p>Idioma preferente: $idioma</p>";
            if ($comentario != "") echo "<p>Comentario:<br>$comentario</p>";
            echo "</article>";
        }
    }
    fclose($archivo);
} else {
    echo "<main class='container'>";
    echo '<p>Para ver los usuarios tienes que haber iniciado sesión</p>';
    echo "<p><a href='../inicio/inicio.php'>Ir a inicio de sesión</a></p>";
}
echo "<p><a class='accent' href='../index.php'>Volver al inicio</a></p>";

echo "</main>";

pie();
