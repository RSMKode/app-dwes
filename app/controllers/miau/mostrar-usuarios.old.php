<?php
//Variables y constantes comunes
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/libs/config.php");
//Libreria de funciones de validación
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/utils.php");
//Libreria de componentes
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/componentes.php");

session_start();
//Se comprueba inactividad, que sea la misma ip de inicio de sesión, y se regenera el id si han pasado 5 minutos
cInactividad($inactivityTime);
cIP();
regenerarSesion();
//Comprobamos el color de la página
cColor();
$esquemaColor = $_COOKIE['esquemaColor'];

cabecera("Usuarios", $rutaEstilos, $esquemaColor);
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/encabezado.php");

echo "<h1>Usuarios</h1>";

if (isset($_SESSION["correo"])) {

    echo "<main class='container listaHorizontal'>";

    $archivo = fopen($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "src" . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "r");
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

            echo "<article class='card'>";

            echo "<h1>$nombre</h1>";
            echo "<p>Correo: $correo</p>";
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
    //Si no se ha iniciado sesión se crea un enlace para iniciar sesión
    echo '<p>Para ver los usuarios tienes que iniciar sesión</p>';
    echo pintaEnlace(APP_ROOT . "controllers/inicio.php", "Ir a inicio de sesión");
}
echo pintaEnlace(APP_ROOT . "index.php", "Volver al inicio");
echo "</main>";

pie();
