<?php
//Variables y constantes comunes
require("/app-dwes-roger-jonathan/libs/config.php");
//Libreria de funciones de validación
require(ROOT . "libs/utils.php");
//Libreria de componentes
require(ROOT . "libs/componentes.php");

session_start();
//Se comprueba inactividad, que sea la misma ip de inicio de sesión, y se regenera el id si han pasado 5 minutos
cInactividad($inactivityTime);
cIP();
regenerarSesion();
//Comprobamos el color de la página
cColor();
$esquemaColor = $_COOKIE['esquemaColor'];

cabecera("Servicios", $rutaEstilos, $esquemaColor);
require(ROOT . "libs/componentes/encabezado.php");

echo "<h1>Servicios</h1>";

if (isset($_SESSION["correo"])) {

    echo "<main class='container listaHorizontal'>";

    $archivo = fopen(ROOT . "src" . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "servicios.txt", "r");
    while (!feof($archivo)) {
        $linea = str_replace("\n", "", fgets($archivo));

        if ($linea != "") {
            $datos = explode("|", $linea);

            $titulo = $datos[0];
            $categoria = $datos[1];
            $descripcion = $datos[2];
            $pago = $datos[3];
            $precio = $datos[4];
            $ubicacion = $datos[5];
            $disponibilidad = $datos[6];
            $rutaFoto = $datos[7];

            echo "<article class='usuario'>";

            echo "<h1>$titulo</h1>";
            echo "<p>Categoria: $categoria</p>";
            echo "<p>Descripcion: $descripcion</p>";
            echo "<p>Ubicacion: $ubicacion </p>";
            echo "<p>Disponibilidad: $disponibilidad</p>";
            if ($pago === "Si") echo "<p>Será de pago</p>";
            if ($precio != "") echo "<p>El precio será de $precio € la hora</p>";
            if ($rutaFoto != "") echo "<img src='$rutaFoto' alt='Imagen de $titulo'>";
            echo "</article>";
        }
    }
    fclose($archivo);
} else {
    echo "<main class='container'>";
    echo '<p>Para ver los servicios disponibles más en detalle tienes que iniciar sesión</p>';
    echo "<p><a href='" . ROOT . "src/pages/inicio/inicio.php'>Ir a inicio de sesión</a></p>";
}
echo "<p><a class='accent' href='" . ROOT . "src/pages/index.php'>Volver al inicio</a></p>";

echo "</main>";

pie();
