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

cabecera("Altas de Servicios", $rutaEstilos, $esquemaColor);
require(ROOT . "libs/componentes/encabezado.php");

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
        $rutaFoto = cFile("fotoServicio", $errores, $extensionesValidas, ROOT . "src" . DIRECTORY_SEPARATOR . $rutaImagenes . DIRECTORY_SEPARATOR . "services", $maxFichero, false);

        /*
        Sino ha habido error en la subida del fichero redireccionamos a valid.php pasando por GET (URL) los datos recogidos
        Si ha habido error volveremos a mostrar el formulario
        */
        if (empty($errores)) {

            //Escribimos datos en fichero
            $archivo = fopen(ROOT . "src" . DIRECTORY_SEPARATOR . "$rutaArchivos" . DIRECTORY_SEPARATOR . "servicios.txt", "a");
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
    echo "<p><a href='" . ROOT . "src/pages/inicio/inicio.php'>Ir a inicio de sesión</a></p>";
}

echo "<p><a class='accent' href='" . ROOT . "src/pages/index.php'>Volver al inicio</a></p>";

echo "</main>";
pie();
