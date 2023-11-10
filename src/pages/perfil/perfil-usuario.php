<?php
require("../../../libs/utils.php");
//De config.php leeremos $extensionesValidas, $rutaImagenes, $maxFichero.
require("../../../libs/config.php");

session_start();

cabecera("Perfil Usuario", "../../styles.css");

echo "<h1>Perfil Usuario</h1>";
echo "<main class='container'>";

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
    echo "<p>Pass: $pass</p>";
    echo "<p>Fecha de nacimiento: $fechaNacimiento</p>";
    if ($rutaFoto != "") echo "<img src='$rutaFoto' alt='Imagen de $nombre'>";
    if ($idioma != "") echo "<p>Idioma preferente: $idioma</p>";
    if ($comentario != "") echo "<p>Comentario:<br>$comentario</p>";

    echo "</article>";

    echo "<a class='accent' href='../perfil/cerrar-sesion.php'>Cerrar sesión</a>";
} else {
    echo "<p>No se ha iniciado sesión</p>";
    echo "<p><a href='../inicio/inicio.php'>Volver a inicio de sesión</a></p>";
}

echo "</main>";

pie();
