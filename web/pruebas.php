<?php
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/libs/config.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/libs/utils.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classIdioma.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classUsuario.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classServicio.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classToken.php");


echo "DOCUMENT ROOT: $_SERVER[DOCUMENT_ROOT]";
echo "<br>";
echo "HTTP HOST: $_SERVER[HTTP_HOST]";
echo "<br>";
echo "RUTA BASE: " . RUTA_BASE;
echo "<br>";
echo "RUTA WEB: " . APP_ROOT;
echo "<br>";

session_start();
echo "ARRAY SESION:<pre>";
print_r($_SESSION);
echo "</pre>";

$idioma = new Idioma();

$idiomas = $idioma->getIdiomasIds();
echo "ARRAY IDIOMAS:<pre>";
print_r($idiomas);
echo "</pre>";
echo "<br>";

$usuario = new Usuario();

$user_idiomas = $usuario->getUsuarioIdiomas(31);
echo "ARRAY USUARIO IDIOMAS:<pre>";
print_r($user_idiomas);
echo "</pre>";
echo "<br>";

$servicio = new Servicio();

$servicios = $servicio->getServicios();
echo "ARRAY SERVICIOS:<pre>";
print_r($servicios);
echo "</pre>";
echo "<br>";

$servicio1 = $servicio->getServicio(1);
echo "SERVICIO 1:<pre>";
print_r($servicio1);
echo "</pre>";
echo "<br>";


// $servicio = new Servicio();

// $servicios = $servicio->getServiciosUser(26);
// echo "ARRAY SERVICIOS:<pre>";
// print_r($servicios);
// echo "</pre>";
// echo "<br>";

// sendEmailToken("dwes@mailinator.com", "aasdsadsa");

$token = new Token();

if ($userid = $token->getTokenUser("65c1163761a8a")) {
    if ($usuario->activarUsuario($userid)) {
        echo "Usuario activado";
        $token->deleteToken($userid);
    } else {
        echo "Error al activar usuario";
    }
}
