<?php

//Libreria de componentes
require("../../../libs/componentes.php");
// Libreria de funciones de validación
require("../../../libs/utils.php");
//De config.php leeremos las variables comunes
require("../../../libs/config.php");

session_start();
cInactividad($inactivityTime);

cabecera("Altas de Servicios", "../../styles.css");
$errores = [];

echo "<h1>Alta de servicio</h1>";
echo "<main class='container'>";

if (!isset($_REQUEST["enviar"]) && isset($_SESSION["correo"])) {
    // Incluimos formulario vacio
    include("form-servicios.php");
} else if (isset($_SESSION["correo"])) {
    $titulo = recoge("titulo");
    $categoria = recoge("categoria");
    $comentario = recoge("comentario");
    $pago = recoge("pago");
    $precio = recoge("precio");
    $ubicacion = recoge("ubicacion");
    $disponibilidad = recoge("disponibilidad");

    //Validamos los campos que no son ficheros
    cTexto($titulo, "titulo", $errores, "nombre");
    cSelect($categoria, "categoria", $errores, $categorias);
    cTexto($comentario, "comentario", $errores, "comentario", 120, 1);
    cRadio($pago, "pago", $errores, $pagos, false);
    cNum($precio, "precio", $errores, false);
    cTexto($ubicacion, "ubicacion",  $errores, "ubi");
    cSelect($disponibilidad, "disponibilidad", $errores, $disponibilidades);

    //Sino ha habido errores en el resto de campos comprobamos el fichero
    if (empty($errores)) {

        //En este caso la subida de la foto no es o<bligatoria
        $rutaFoto = cFile("fotoServicio", $errores, $extensionesValidas, "../../$rutaImagenes", $maxFichero, false);

        /*
        Sino ha habido error en la subida del fichero redireccionamos a valid.php pasando por GET (URL) los datos recogidos
        Si ha habido error volveremos a mostrar el formulario
        */
        if (empty($errores)) {

            //Escribimos datos en fichero
            $archivo = fopen("../../$rutaArchivos" . DIRECTORY_SEPARATOR . "servicios.txt", "a");
            fwrite($archivo, $titulo . "|" . $categoria . "|" . $comentario . "|" . $pago . "|" . $precio . "|" . $ubicacion . "|" . $disponibilidad . "|" . $rutaFoto . "|" . PHP_EOL);
            fclose($archivo);

            //Redirigimos a valid.php
            header("location:mostrar-servicios.php");
        } else {
            require("form-servicios.php");
        }
    } else {
        require("form-servicios.php");
    }
} else {
    echo '<p>Para dar de alta un servicio tienes que haber iniciado sesión</p>';
    echo "<p><a href='../inicio/inicio.php'>Ir a inicio de sesión</a></p>";
}

echo "<p><a class='accent' href='../index.php'>Volver al inicio</a></p>";

echo "</main>";
pie();
