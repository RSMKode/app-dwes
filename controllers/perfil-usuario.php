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

cabecera("Perfil Usuario", $rutaEstilos, $esquemaColor);
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/encabezado.php");

echo "<h1>Perfil Usuario</h1>";

echo "<main class='container'>";
/*
Lo mismo que os he comentado en alta de registro para impedir que esto lo vea un usuario no logueado
*/
if (isset($_SESSION["nivel"]) && $_SESSION["nivel"] == 1) {

    $email = $_SESSION["email"];
    $pass = $_SESSION["pass"];
    $nombre = $_SESSION["nombre"];
    $f_nacimiento = $_SESSION["f_nacimiento"];
    $foto_perfil = $_SESSION["foto_perfil"];
    $descripcion = $_SESSION["descripcion"];
    $nivel = $_SESSION["nivel"];
    // $idioma = $_SESSION["idioma"];

    echo "<article class='usuario'>";

    echo "<h1>$nombre</h1>";
    echo "<p>email: $email</p>";
    echo "<p>Contraseña: ********</p>";
    echo "<p>Fecha de nacimiento: $f_nacimiento</p>";
    if ($foto_perfil != "") echo "<img src='$foto_perfil' alt='Imagen de $nombre'>";
    if ($descripcion != "") echo "<p>Comentario:<br>$descripcion</p>";
    echo "<p>Nivel: $nivel</p>";
    // if ($idioma != "") echo "<p>Idioma preferente: $idioma</p>";

    echo "</article>";

    echo pintaEnlace(APP_ROOT . "controllers/cerrar-sesion.php", "Cerrar sesión");
} else {
    echo "<p>No se ha iniciado sesión</p>";

    echo pintaEnlace(APP_ROOT . "controllers/inicio.php", "Volver a inicio de sesión");
}
echo pintaEnlace(APP_ROOT . "index.php", "Volver al inicio");

echo "</main>";

pie();
