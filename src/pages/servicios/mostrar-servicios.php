<?php

//Libreria de componentes
require("../../../libs/componentes.php");
// Libreria de funciones de validación
require("../../../libs/utils.php");
//De config.php leeremos las variables comunes
require("../../../libs/config.php");

session_start();
cInactividad($inactivityTime);

cabecera("Servicios", "../../styles.css");
echo "<h1>Servicios</h1>";

if (isset($_SESSION["correo"])) {

    echo "<main class='container listaHorizontal'>";

    $archivo = fopen(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "servicios.txt", "r");
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
    echo "<p><a href='../inicio/inicio.php'>Ir a inicio de sesión</a></p>";
}
echo "<p><a class='accent' href='../index.php'>Volver al inicio</a></p>";

echo "</main>";

pie();
