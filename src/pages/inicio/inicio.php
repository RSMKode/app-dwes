<?php
//Libreria de componentes
require("../../../libs/componentes.php");
// Libreria de funciones de validación
require("../../../libs/utils.php");
//De config.php leeremos las variables comunes
require("../../../libs/config.php");

session_start();
cInactividad($inactivityTime);

cabecera("Registro", "../../styles.css");
$errores = [];

echo "<h1>Iniciar Sesión</h1>";
echo "<main class='container'>";

if (isset($_SESSION["correo"])) {
    // Si ya se ha iniciado sesión, redirigimos a la página principal
    echo "<p>Ya has iniciado sesión.</p>";
    echo "<a class='accent' href='../perfil/perfil-usuario.php'>Ir al perfil de usuario</a>";
} else if (!isset($_REQUEST['enviar'])) {
    // Incluimos formulario vacio
    require("form-inicio.php");
} else {
    //Sanitizamos
    $correo = recoge("correo");
    $pass = recoge("pass");

    //Validamos los campos que no son ficheros
    cTexto($correo, "correo", $errores, "correo");
    cTexto($pass, "pass", $errores, "pass", 30, 4);

    if (empty($errores)) {

        $archivo = fopen(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "r");
        while (!feof($archivo)) {
            $linea = str_replace("\n", "", fgets($archivo));

            if ($linea != "") {
                $datos = explode("|", $linea);

                $correoTemp = $datos[0];
                $passTemp = $datos[1];

                if ($correoTemp == $correo && $passTemp == $pass) {

                    $correo = $datos[0];
                    $pass = $datos[1];
                    $nombre = $datos[2];
                    $fechaNacimiento = $datos[3];
                    $rutaFoto = $datos[4];
                    $idioma = $datos[5];
                    $comentario = $datos[6];
                    fclose($archivo);

                    $_SESSION["correo"] = $correo;
                    $_SESSION["pass"] = $pass;
                    $_SESSION["nombre"] = $nombre;
                    $_SESSION["fechaNacimiento"] = $fechaNacimiento;
                    $_SESSION["rutaFoto"] = $rutaFoto;
                    $_SESSION["idioma"] = $idioma;
                    $_SESSION["comentario"] = $comentario;
                    $_SESSION["momentoLogin"] = time();
                    header("location:../perfil/perfil-usuario.php");
                }
            }
        }
        fclose($archivo);

        //Si no se encuentra el usuario en el archivo guardamos un log del fallo de inicio de sesión
        $horaActual = date("d-m-Y H:i:s");
        $archivo = fopen(".." . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "logLogin.txt", "a");
        fwrite($archivo, $correo . "|" . $pass . "|" . $horaActual . "|" . PHP_EOL);
        fclose($archivo);

        echo "<h2>Datos incorrectos</h2>";
        echo "<p><a class='accent' href='./inicio.php'>Volver a intentar</a></p>";
    } else {
        require("form-inicio.php");
    }
}
echo "<p><a class='accent' href='../index.php'>Volver al inicio</a></p>";

echo "</main>";
pie();
