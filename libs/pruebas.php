<?php
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/libs/config.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/model/classIdioma.php");
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/model/classUsuario_Idioma.php");


echo $_SERVER["DOCUMENT_ROOT"];
echo "<br>";
echo APP_ROOT;
echo "<br>";
echo $_SERVER["HTTP_HOST"];
echo "<br>";


$idioma = new Idioma();

$idiomas_ids = $idioma->getIdiomas();
$id = 2;
print_r($idiomas_ids);
$user = 7;

$useridioma = new Usuario_Idioma();

$useridioma->addIdiomaUsuario($user, $id);
// $useridioma->addIdiomaUsuario(6, 2);
// $useridioma->addIdiomaUsuario(7, 2);
