<?php
//Variables y constantes comunes
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes-roger-jonathan/libs/config.php");
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

cabecera("Perfil Usuario", $rutaEstilos, $esquemaColor);
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/componentes/encabezado.php");

echo "<h1>Perfil Usuario</h1>";

echo "<main class='container'>";
/*
Lo mismo que os he comentado en alta de registro para impedir que esto lo vea un usuario no logueado
*/
if (isset($_SESSION["correo"])) {

    $correo = $_SESSION["correo"];
    $pass = $_SESSION["pass"];
    $nombre = $_SESSION["nombre"];
    $fechaNacimiento = $_SESSION["fechaNacimiento"];
    $rutaFoto = $_SESSION["rutaFoto"];
    $idioma = $_SESSION["idioma"];
    $comentario = $_SESSION["comentario"];

    echo "<article class='usuario'>";

    echo "<h1>$nombre</h1>";
    echo "<p>Correo: $correo</p>";
    echo "<p>Contraseña: ********</p>";
    echo "<p>Fecha de nacimiento: $fechaNacimiento</p>";
    if ($rutaFoto != "") echo "<img src='$rutaFoto' alt='Imagen de $nombre'>";
    if ($idioma != "") echo "<p>Idioma preferente: $idioma</p>";
    if ($comentario != "") echo "<p>Comentario:<br>$comentario</p>";

    echo "</article>";

    echo pintaEnlace(APP_ROOT . "src/pages/perfil/cerrar-sesion.php", "Cerrar sesión");
} else {
    echo "<p>No se ha iniciado sesión</p>";

    echo pintaEnlace(APP_ROOT . "src/pages/inicio/inicio.php", "Volver a inicio de sesión");
}
echo pintaEnlace(APP_ROOT . "src/pages/index.php", "Volver al inicio");

echo "</main>";

pie();
