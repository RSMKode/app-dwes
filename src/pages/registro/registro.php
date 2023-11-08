<?php
require("../../../libs/utils.php");
//De config.php leeremos $extensionesValidas, $rutaImagenes, $maxFichero.
require("../../../libs/config.php");

cabecera("Registro", "../../styles.css");
$errores = [];

echo "<h1>Registro</h1>";
echo "<main class='container'>";
print_r($_FILES);

if (!isset($_REQUEST['enviar'])) {
    // Incluimos formulario vacio
    require("form-registro.php");
} else {
    //Sanitizamos
    $nombre = recoge("nombre");
    $correo = recoge("correo");
    $pass = recoge("pass");
    $fechaNacimiento = recoge("fechaNacimiento");
    $idioma = recoge("idioma");
    $comentario = recoge("comentario");


    //Validamos los campos que no son ficheros
    cTexto($nombre, "nombre", $errores, 40, 1);
    cCorreo($correo, "correo", $errores);
    cPass($pass, "pass", $errores, 30, 4);
    cFecha($fechaNacimiento, "fechaNacimiento", $errores, FORMATOS_FECHA[1]);
    cTexto($idioma, "idioma", $errores, 20, 0);
    cTexto($comentario, "comentario", $errores, 300, 0);

    //Sino ha habido errores en el resto de campos comprobamos el fichero
    if (empty($errores)) {

        //En este caso la subida de la foto no es obligatoria
        $rutaFoto = cFile("foto", $errores, $extensionesValidas, "../../$rutaImagenes", $maxFichero, false);

        /*
         Si no ha habido error en la subida del fichero redireccionamos a valid.php pasando por GET (URL) los datos recogidos
         Si ha habido error volveremos a mostrar el formulario
         */
        if (empty($errores)) {

            //Escribimos datos en fichero
            $archivo = fopen("../../$rutaArchivos" . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "a");
            fwrite($archivo, $nombre . "|" . $correo . "|" . $pass . "|" . $fechaNacimiento . "|" . $rutaFoto . "|" . $idioma . "|" . $comentario . "|" . PHP_EOL);
            fclose($archivo);

            //Redirigimos a valid.php
            header("location:registro_valid.php");
        } else {
            require("form-registro.php");
        }
    } else {
        require("form-registro.php");
    }
}
echo "</main>";
pie();
