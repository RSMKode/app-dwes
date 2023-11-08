<?php


// Libreria de funciones de validación
require("../../../libs/utils.php");
//De config.php leeremos $extensionesValidas, $rutaImagenes, $maxFichero.
require("../../../libs/config.php");



cabecera("Modificaciones", "../../styles.css");
$errores = [];


echo "<h1>Modificacion perfil</h1>";
echo "<main class='container'>";

//Comprobamos si se ha pulsado el submit

if (!isset($_REQUEST["enviar"])) {
    include("form-modif.php");
} else {
    //Sanitizacion
    $comentario = recoge("text");
    $newpassword = recoge("pass");
    $idioma = recoge("idioma");

    //Validacion
    cTexto($newpassword, "contrasenya", $errores, 15, 6, false);
    cTexto($comentario, "descripcion", $errores, 120, 10);
    cSelect($idioma, "idioma", $errores, $idiomas);


    //Sino ha habido errores en el resto de campos comprobamos el fichero
    if (empty($errores)) {

        //En este caso la subida de la foto no es obligatoria
        $rutaFoto = cFile("foto", $errores, $extensionesValidas, "../../$rutaImagenes", $maxFichero, false);

        /*
         Sino ha habido error en la subida del fichero redireccionamos a valid.php
         Si ha habido error volveremos a mostrar el formulario
         */
        if (empty($errores)) {
            $archivo = fopen("../../$rutaArchivos" . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "r");
            while (!feof($archivo)) {
                $linea = str_replace("\n", "", fgets($archivo));

                if ($linea != "") {
                    $datos = explode("|", $linea);

                    $nombre = $datos[0];
                    $correo = $datos[1];
                    $datos[2] = $newpassword;
                    $fechaNacimiento = $datos[3];
                    $datos[4] = $rutaFoto;
                    $datos[5] = $idioma;
                    $datos[6] = $comentario;
                }

                fclose($archivo);

                //Escribimos datos en fichero
                $archivo = fopen("../../$rutaArchivos" . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "a");
                fwrite($archivo, $nombre . "|" . $correo . "|" . $datos[2] . "|" . $fechaNacimiento . "|" . $datos[4] . "|" . $datos[5] . "|" . $datos[6] . "|" . PHP_EOL);
            }
            fclose($archivo);

            //Redirigimos a valid.php
            header("location:modif_valid.php");
        } else {
            require("form-modif.php");
        }
    } else {
        require("form-modif.php");
    }
}
echo "</main>";
pie();
