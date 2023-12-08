<?php
//Variables y constantes comunes
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes-roger-jonathan/libs/config.php");
//Libreria de funciones de validación
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/utils.php");
//Libreria de componentes
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/componentes.php");

session_start();
//Se comprueba inactividad, que sea la misma ip de inicio de sesión, y se regenera el id si han pasado 5 minutos
/*
    Hasta que no se ha logueado el usuario no comprobamos IP, ni regeneramos ID ni cerramos por inactividad
    En el login se guardan los datos iniciales y a partir de ese momento se van comprobando en las páginas privadas
*/
cInactividad($inactivityTime);
cIP();
regenerarSesion();
//Comprobamos el color de la página
cColor();
$esquemaColor = $_COOKIE['esquemaColor'];

cabecera("Registro", $rutaEstilos, $esquemaColor);
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/encabezado.php");

$errores = [];

echo "<h1>Iniciar Sesión</h1>";
echo "<main class='container'>";

if (isset($_SESSION["correo"])) {
    // Si ya se ha iniciado sesión, creamos enlace a la página principal
    echo "<p>Ya has iniciado sesión.</p>";
    echo pintaEnlace(APP_ROOT . "/controllers/perfil-usuario.php", "Ir al perfil de usuario");
} else if (!isset($_REQUEST['enviar'])) {
    // Incluimos formulario de inicio de sesión
    require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/form-inicio.php");
} else {
    //Sanitizamos
    $correo = recoge("correo");
    $pass = recoge("pass");

    //Validamos los campos de correo y fecha
    cTexto($correo, "correo", $errores, "correo");
    cTexto($pass, "pass", $errores, "pass", 30, 4);

    if (empty($errores)) {
        /*
    El código de la comprobación del usuario y la contraseña mejor en una función, hace el código más claro y fácil de modificar.
    Ademas la función se podría reutilizar.
    La función devolverá los datos del fichero en caso de que usuario y contraseña ssean correctos y false en caso contrario
*/
        $archivo = fopen($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "src" . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "datosUsuarios.txt", "r");
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
                    $_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];
                    header("location:../perfil-usuario.php");
                }
            }
        }
        fclose($archivo);

        //Si no se encuentra el usuario en el archivo guardamos un log del fallo de inicio de sesión
        $horaActual = date("d-m-Y H:i:s");
        $archivo = fopen($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "logLogin.txt", "a");
        fwrite($archivo, $correo . "|" . $pass . "|" . $horaActual . "|" . PHP_EOL);
        fclose($archivo);

        echo "<h2>Datos incorrectos</h2>";
        echo pintaEnlace("./inicio.php", "Volver a intentar");
    } else {
        require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/form-inicio.php");
    }
}
echo pintaEnlace(APP_ROOT . "index.php", "Volver al inicio");

echo "</main>";
pie();
