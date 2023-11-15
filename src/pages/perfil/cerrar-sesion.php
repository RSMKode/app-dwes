<?php
//Variables y constantes comunes
require("/app-dwes-roger-jonathan/libs/config.php");
//Libreria de funciones de validación
require(ROOT . "libs/utils.php");
//Libreria de componentes
require(ROOT . "libs/componentes.php");

session_start();


//Comprobamos el color de la página
cColor();
$esquemaColor = $_COOKIE['esquemaColor'];

cabecera("Sesión cerrada", $rutaEstilos, $esquemaColor);
require(ROOT . "libs/componentes/encabezado.php");

echo '<main class="container">';
if (isset($_SESSION["momentoLogin"])) {

    if (time() > $_SESSION["momentoLogin"] + $inactivityTime) {
        echo "Se ha cerrado su sesión por inactividad tras " . round($inactivityTime / 60, 2) . " minutos";
    } else {
        echo "Se ha cerrado su sesión";
    }
} else if (isset($_SESSION["ip"])) {
    if ($_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
        echo "Se ha cerrado su sesión, IP diferente.";
    }
} else {
    header("Location:" . ROOT . "/src/pages/inicio/inicio.php");
}
session_unset();
session_destroy();

echo pintaEnlace(ROOT . "src/pages/index.php", "Ir al inicio");

echo '<main>';

pie();
