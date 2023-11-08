<?php
require("../../../libs/utils.php");
//De config.php leeremos $extensionesValidas, $rutaImagenes, $maxFichero.
require("../../../libs/config.php");

cabecera("Registro completado", "../../styles.css");

echo "<h1>Registro Completado</h1>";
echo "<main class='container'>";

$archivo = fopen("../../$rutaArchivos" . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "r");
while (!feof($archivo)) {
    $linea = str_replace("\n", "", fgets($archivo));

    if ($linea != "") {
        $datos = explode("|", $linea);

        $nombre = $datos[0];
        $correo = $datos[1];
        $pass = $datos[2];
        $fechaNacimiento = $datos[3];
        $rutaFoto = $datos[4];
        $idioma = $datos[5];
        $comentario = $datos[6];

        echo "<h1>$nombre</h1>";
        echo "<p>Correo: $correo</p>";
        echo "<p>Pass: $pass</p>";
        echo "<p>Fecha de nacimiento: $fechaNacimiento</p>";
        if ($rutaFoto != "") echo "<img src='$rutaFoto' alt='Imagen de $nombre'>";
        if ($idioma != "") echo "<p>Idioma preferente: $idioma</p>";
        if ($comentario != "") echo "<p>Comentario:<br>$comentario</p>";
        echo "<hr>";
    }
}
fclose($archivo);

echo "</main>";

pie();
