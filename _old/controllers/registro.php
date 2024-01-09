<?php
//Variables y constantes comunes
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/libs/config.php");
//Libreria de funciones de validación
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/utils.php");
//Libreria de componentes
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/componentes.php");
//Libreria de seguridad
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/seguridad.php");

//CLASES MODELO
require("../model/classUsuario.php");

session_start();
//Se comprueba inactividad, que sea la misma ip de inicio de sesión, y se regenera el id si han pasado 5 minutos
cInactividad($inactivityTime);
cIP();
regenerarSesion();
//Comprobamos el color de la página
cColor();
/*
Las cookies hay que sanitizarlas. Al estar en el navegador son inseguras
*/
$esquemaColor = $_COOKIE['esquemaColor'];

cabecera("Registro", $rutaEstilos, $esquemaColor);
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/encabezado.php");

$errores = [];
$datos_usuario = [];

echo "<h1>Registro</h1>";
echo "<main class='container'>";
/*
Si ya se ha iniciado lo mejor es redirigir a otra página o en este caso mostrar el mensaje en el formulario con $errores
*/

if (isset($_SESSION["nivel"]) && $_SESSION["nivel"] == 1) {
    // Si ya se ha iniciado sesión, creamos enlace a la página principal
    echo "<p>Ya has iniciado sesión.</p>";
    echo pintaEnlace(APP_ROOT . "controllers/perfil-usuario.php", "Ir al perfil de usuario");
} else if (!isset($_REQUEST['enviar'])) {
    // Incluimos formulario vacio
    require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/form-registro.php");
} else {
    //Sanitizamos
    $datos_usuario["nombre"] = recoge("nombre");
    $datos_usuario["email"] = recoge("correo");
    $datos_usuario["pass"] = recoge("pass");
    $datos_usuario["f_nacimiento"] = recoge("fechaNacimiento");
    $datos_usuario["descripcion"] = recoge("descripcion");
    // $idioma = recogeArray("idioma");

    //Validamos los campos que no son ficheros
    cTexto($datos_usuario["nombre"], "nombre", $errores, "nombre", 40, 1);
    cTexto($datos_usuario["email"], "correo", $errores, "correo");
    cTexto($datos_usuario["pass"], "pass", $errores, "pass", 30, 4);
    cFecha($datos_usuario["f_nacimiento"], "fechaNacimiento", $errores, FORMATOS_FECHA[1]);
    cTexto($datos_usuario["descripcion"], "descripcion", $errores, "descripcion", 300, 0);
    // cSelect($idioma, "idioma", $errores, $idiomas, 0);

    //Sino ha habido errores en el resto de campos comprobamos el fichero
    if (empty($errores)) {

        //En este caso la subida de la foto no es obligatoria
        $datos_usuario["foto_perfil"] = cFile("foto", $errores, $extensionesValidas, ".." . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . $rutaImagenes . DIRECTORY_SEPARATOR . "users", $maxFichero, false);

        /*
        Sino ha habido error en la subida del fichero redireccionamos a perfil-usuario.php
         Si ha habido error volveremos a mostrar el formulario
         */
        if (empty($errores)) {

            $datos_usuario["pass"] = encriptar($datos_usuario["pass"]);

            $usuario = new Usuario();

            $usuario->addUsuario($datos_usuario);


            $_SESSION["id_user"] = $datos_usuario["id_user"];
            $_SESSION["email"] = $datos_usuario["email"];
            $_SESSION["pass"] = $datos_usuario["pass"];
            $_SESSION["nombre"] = $datos_usuario["nombre"];
            $_SESSION["f_nacimiento"] = $datos_usuario["f_nacimiento"];
            $_SESSION["foto_perfil"] = $datos_usuario["foto_perfil"];
            // $_SESSION["idioma"] = $datos_usuario["idioma"];
            $_SESSION["descripcion"] = $datos_usuario["descripcion"];
            $_SESSION["nivel"] = $datos_usuario["nivel"];
            $_SESSION["momentoLogin"] = time();
            $_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];

            //Redirigimos
            header("location:./mostrar-usuarios.php");
        } else {
            require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/form-registro.php");
        }
    } else {
        require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/form-registro.php");
    }
}
echo pintaEnlace(APP_ROOT . "index.php", "Volver al inicio");
echo "</main>";
pie();
