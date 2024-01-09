<?php
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/libs/config.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classIdioma.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/app/model/classUsuario_Idioma.php");


echo $_SERVER["DOCUMENT_ROOT"];
echo "<br>";
echo APP_ROOT;
echo "<br>";
echo $_SERVER["HTTP_HOST"];
echo "<br>";

session_start();

$idioma = new Idioma();

$idiomas = $idioma->getIdiomasIds();

print_r($idiomas);

print_r($_SESSION);
