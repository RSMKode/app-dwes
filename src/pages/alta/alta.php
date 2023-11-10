<?php
// Libreria de funciones de validación
require("../../../libs/utils.php");
//De config.php leeremos $extensionesValidas, $rutaImagenes, $maxFichero.
require("../../../libs/config.php");



cabecera("Altas de Servicios", "../../styles.css" );
$errores=[];


echo "<h1>Alta de servicio</h1>";
echo "<main class='container'>";
print_r($_FILES);

$categorias = array(
    "categoria1",
    "categoria2",
    "categoria3",
);


$disponibilidades = array(
    "mañana",
    "tarde",
    "noche",
);

$pagos = array(
    "si",
    "no",
);

if(!isset($_REQUEST["enviar"])){
    // Incluimos formulario vacio
    include("form-alta.php");
}else{
    $titulo = recoge("titul");
    $categoria = recoge("cat");
    $comentario = recoge("comentario");
    $pago = recoge("pago");
    $precio = recoge("precio");
    $ubicacion = recoge("ubicacion");
    $disponibilidad = recoge("disponibilidad");

    //Validamos los campos que no son ficheros
    cTexto($titulo, "titulo", $errores, "texto");
    cSelect($categoria, "categoria", $errores, $categorias);
    cTexto($comentario, "comentario", $errores, "texto", 120);
    cRadio($pago, "pago", $errores, $pagos, false);
    cNum($precio, "precio", $errores, false);
    cTexto($ubicacion, "ubicacion",  $errores, "ubi");
    cSelect($disponibilidad, "disponibilidad", $errores, $disponibilidades);

//Sino ha habido errores en el resto de campos comprobamos el fichero
if(empty($errores)){
    //En este caso la subida de la foto no es obligatoria

    $rutaFoto = cFile("foto", $errores, $extensionesValidas, "../../$rutaImagenes", $maxFichero, false);

    /*
             Sino ha habido error en la subida del fichero redireccionamos a valid.php pasando por GET (URL) los datos recogidos
             Si ha habido error volveremos a mostrar el formulario
             */
    if(empty($errores)) {

        //Escribimos datos en fichero
        $archivo = fopen("../../$rutaArchivos" . DIRECTORY_SEPARATOR . "ServicioUsuarios.txt", "a");
        fwrite($archivo, $titulo . "|" . $categoria . "|" . $comentario . "|" . $pago . "|" . $precio . "|" . $ubicacion . "|" . $disponibilidad . "|" . PHP_EOL);
        fclose($archivo);

        //Redirigimos a valid.php
        header("location:registro_valid.php");
    } else {
        require("form-alta.php");
    }
} else {
    require("form-alta.php");
}
}

echo "</main>";
pie();
