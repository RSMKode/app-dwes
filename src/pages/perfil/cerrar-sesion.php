<?php
//Libreria de componentes
require("../../../libs/componentes.php");
// Libreria de funciones de validación
require("../../../libs/utils.php");
//De config.php leeremos las variables comunes
require("../../../libs/config.php");

session_start();

cabecera("Sesión cerrada", "../../styles.css");

echo '<main class="container">';
if (isset($_SESSION["momentoLogin"])) {

    if (time() > $_SESSION["momentoLogin"] + $inactivityTime) {
        echo "Se ha cerrado su sesión por inactividad tras " . round($inactivityTime / 60, 2) . " minutos";
    } else {
        echo "Se ha cerrado su sesión";
    }
} else {
    header("Location:" . ROOT . "src/pages/inicio/inicio.php");
}
session_destroy();

echo '<a href="' . ROOT . 'src/pages/index.php">Ir al inicio</a>';

echo '<main>';

pie();
