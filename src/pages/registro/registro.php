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

cabecera("Registro", $rutaEstilos, $esquemaColor);
require(ROOT . "libs/componentes/encabezado.php");

$errores = [];

echo "<h1>Registro</h1>";
echo "<main class='container'>";

if (isset($_SESSION["correo"])) {
    // Si ya se ha iniciado sesión, redirigimos a la página principal
    echo "<p>Ya has iniciado sesión.</p>";
    echo "<a clas='accent' href='../perfil/perfil-usuario.php'>Ir al perfil de usuario</a>";
} else if (!isset($_REQUEST['enviar'])) {
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
    cTexto($nombre, "nombre", $errores, "nombre", 40, 1);
    cTexto($correo, "correo", $errores, "correo");
    cTexto($pass, "pass", $errores, "pass", 30, 4);
    cFecha($fechaNacimiento, "fechaNacimiento", $errores, FORMATOS_FECHA[1]);
    cSelect($idioma, "idioma", $errores, $idiomas, 0);
    cTexto($comentario, "comentario", $errores, "comentario", 300, 0);

    //Sino ha habido errores en el resto de campos comprobamos el fichero
    if (empty($errores)) {

        //En este caso la subida de la foto no es obligatoria
        $rutaFoto = cFile("foto", $errores, $extensionesValidas, "../../$rutaImagenes/users", $maxFichero, false);

        /*
         Si no ha habido error en la subida del fichero redireccionamos a valid.php
         Si ha habido error volveremos a mostrar el formulario
         */
        if (empty($errores)) {

            //Escribimos datos en fichero
            $archivo = fopen(ROOT . "src" . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "a");
            fwrite($archivo, $correo . "|" . $pass . "|" . $nombre . "|" . $fechaNacimiento . "|" . $rutaFoto . "|" . $idioma . "|" . $comentario . "|" . PHP_EOL);
            fclose($archivo);

            $_SESSION["correo"] = $correo;
            $_SESSION["pass"] = $pass;
            $_SESSION["nombre"] = $nombre;
            $_SESSION["fechaNacimiento"] = $fechaNacimiento;
            $_SESSION["rutaFoto"] = $rutaFoto;
            $_SESSION["idioma"] = $idioma;
            $_SESSION["comentario"] = $comentario;
            $_SESSION["momentoLogin"] = time();

            //Redirigimos a valid.php
            header("location:../inicio/inicio.php");
        } else {
            require("form-registro.php");
        }
    } else {
        require("form-registro.php");
    }
}
echo "<p><a class='accent' href='../index.php'>Volver al inicio</a></p>";
echo "</main>";
pie();
