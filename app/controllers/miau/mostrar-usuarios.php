<?php
//Variables y constantes comunes
require($_SERVER["DOCUMENT_ROOT"] . "/app-dwes/libs/config.php");
//Libreria de funciones de validación
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/utils.php");
//Libreria de componentes
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/componentes.php");
//CLASES MODELO
require("../model/classUsuario.php");


session_start();
//Se comprueba inactividad, que sea la misma ip de inicio de sesión, y se regenera el id si han pasado 5 minutos
cInactividad($inactivityTime);
cIP();
regenerarSesion();
//Comprobamos el color de la página
cColor();
$esquemaColor = $_COOKIE['esquemaColor'];

cabecera("Usuarios", $rutaEstilos, $esquemaColor);
require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/encabezado.php");

echo "<h1>Usuarios</h1>";

if (isset($_SESSION["nivel"]) && $_SESSION["nivel"] == 1) {

    echo "<main class='container listaHorizontal'>";

    $usuario = new Usuario();
    $user_ids = $usuario->getUsuariosIds();

    foreach ($user_ids as $valor) {
        $id = $valor["id_user"];

        $datos = $usuario->getUsuario($id);

        //DEBUG
        // print_r($datos);

        if ($datos['activo'] == 0) {
            echo "<article class='card'>";

            echo "<h1>" . $datos['nombre'] . "</h1>";
            echo "<p>ID; " . $datos['id_user'] . "</p>";
            echo "<p>Email: " . $datos['email'] . "</p>";
            echo "<p>Pass: " . $datos['pass'] . "</p>";
            echo "<p>Fecha de nacimiento:" . $datos['f_nacimiento'] . "</p>";
            if ($datos['foto_perfil'] != "") echo "<img src='" . $datos['foto_perfil'] . "' alt='Imagen de " . $datos['nombre'] . "'>";
            if ($datos['descripcion'] != "") echo "<p>Descripción:<br>" . $datos['descripcion'] . "</p>";
            echo "<p>Nivel de usuario:" . $datos['nivel'] . "</p>";
            // if ($idioma != "") echo "<p>Idioma preferente: $idioma</p>";
            echo "</article>";
        }
    }
} else {
    echo "<main class='container'>";
    //Si no se ha iniciado sesión se crea un enlace para iniciar sesión
    echo '<p>Para ver los usuarios tienes que iniciar sesión</p>';
    echo pintaEnlace(APP_ROOT . "controllers/inicio.php", "Ir a inicio de sesión");
}


echo pintaEnlace(APP_ROOT . "index.php", "Volver al inicio");
echo "</main>";

pie();
