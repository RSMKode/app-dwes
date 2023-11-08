<?php

require("../../../libs/utils.php");
//De config.php leeremos $extensionesValidas, $rutaImagenes, $maxFichero.
require("../../../libs/config.php");

cabecera("Servicio añadido", "../../styles.css");

echo "<h1>Servicio añadido</h1>";
echo "<main class='container'>";

$archivo = fopen("../../$rutaArchivos" . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "r");
while (!feof($archivo)) {
    $linea = str_replace("\n", "", fgets($archivo));

    if ($linea != "") {
        $datos = explode("|", $linea);

        $titulo = $datos[0];
        $categoria = $datos[1];
        $comentario = $datos[2];
        $pago = $datos[3];
        $precio = $datos[4];
        $ubicacion = $datos[5];
        $disponibilidad = $datos[6];

        echo "<h1>$titulo</h1>";
        echo "<p>Categoria: $categoria</p>";
        echo "<p>Descripcion: $comentario</p>";
        echo "<p>Ubicacion: $ubicacion </p>";
        echo "<p>Disponibilidad: $disponibilidad</p>";
        if ($pago === "si") echo "<p>Será de pago</p>";
        if ($precio != "") echo "<p>el precio será de $precio</p>";
        if ($rutaFoto != "") echo "<img src='$rutaFoto' alt='Imagen de $titulo'>";
        echo "<hr>";
    }
}
fclose($archivo);

echo "</main>";

pie();

