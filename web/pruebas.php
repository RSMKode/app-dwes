<?php
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/libs/config.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classIdioma.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classUsuarioIdioma.php");


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
