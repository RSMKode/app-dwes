<?php

require("../../../libs/utils.php");
//De config.php leeremos $extensionesValidas, $rutaImagenes, $maxFichero.
require("../../../libs/config.php");

cabecera("Servicios", "../../styles.css");

echo "<h1>Servicios</h1>";
echo "<main class='container listaUsers'>";

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

echo "<a class='accent' href='../index.php'>Volver al inicio</a>";

echo "</main>";

pie();
