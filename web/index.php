<?php

//Variables y constantes comunes
require("../app/libs/config.php");
//Libreria de funciones de validación
require("../app/libs/utils.php");
//Libreria de componentes
require("../app/libs/componentes.php");
//Clase sesión
require("../app/libs/classSesion.php");
require("../app/libs/seguridad.php");
require("../app/controllers/Controller.php");
require("../app/controllers/ControllerUser.php");
require("../app/controllers/ControllerService.php");
//Modelos
require("../app/model/classUsuario.php");
require("../app/model/classToken.php");
require("../app/model/classIdioma.php");
require("../app/model/classServicio.php");
require("../app/model/classDisponibilidad.php");

$sesion = Sesion::getInstance();

//Comprobamos el color de la página
cColor();

$map = [
    /*
    En cada elemento podemos añadir una posición mas que se encargará de otorgar el nivel mínimo para ejecutar la acción
    Puede quedar de la siguiente manera
    'inicio' => array('controller' =>'Controller', 'action' =>'inicio', 'nivel_usuario'=>0)
    */
    'indice' => ['controller' => 'Controller', 'action' => 'indice', 'nivel_usuario' => 0],
    'error' => ['controller' => 'Controller', 'action' => 'error', 'nivel_usuario' => 0],
    'registro' => ['controller' => 'ControllerUser', 'action' => 'registro', 'nivel_usuario' => 0],
    'inicio_sesion' => ['controller' => 'ControllerUser', 'action' => 'inicio_sesion', 'nivel_usuario' => 0],
    'cerrar_sesion' => ['controller' => 'ControllerUser', 'action' => 'cerrar_sesion', 'nivel_usuario' => 0],
    'perfil_usuario' => ['controller' => 'ControllerUser', 'action' => 'perfil_usuario', 'nivel_usuario' => 1],
    'perfil_editar' => ['controller' => 'ControllerUser', 'action' => 'perfil_editar', 'nivel_usuario' => 1],
    'lista_usuarios' => ['controller' => 'ControllerUser', 'action' => 'lista_usuarios', 'nivel_usuario' => 2],
    'servicios_alta' => ['controller' => 'ControllerService', 'action' => 'servicios_alta', 'nivel_usuario' => 1],
    'servicios' => ['controller' => 'ControllerService', 'action' => 'servicios', 'nivel_usuario' => 1],
    'servicio' => ['controller' => 'ControllerService', 'action' => 'servicio', 'nivel_usuario' => 1],
    'servicios_usuario' => ['controller' => 'ControllerService', 'action' => 'servicios_usuario', 'nivel_usuario' => 1],
    'admin' => ['controller' => 'ControllerUser', 'action' => 'admin', 'nivel_usuario' => 2],
];
// Parseo de la ruta
if (isset($_GET['ctl'])) {
    if (isset($map[$_GET['ctl']])) {
        $ruta = $_GET['ctl'];
    } else {

        //Si el valor puesto en ctl en la URL no existe en el array de mapeo envía una cabecera de error
        header('Location:index.php?ctl=error&error=' . $_GET['ctl']);
    }
} else {
    $ruta = 'indice';
}
$controlador = $map[$ruta];
/* 
Comprobamos si el metodo correspondiente a la acción relacionada con el valor de ctl existe, si es así ejecutamos el método correspondiente.
En aso de no existir cabecera de error.
En caso de estar utilizando sesiones y permisos en las diferentes acciones comprobariaos tambien si el usuario tiene permiso suficiente para ejecutar esa acción
*/

if (method_exists($controlador['controller'], $controlador['action'])) {
    if ($controlador['nivel_usuario'] <= $_SESSION['nivel']) {
        call_user_func([
            new $controlador['controller'],
            $controlador['action']
        ]);
    } else {
        header('Location:index.php?ctl=inicio_sesion');
    }
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> no existe</h1></body></html>';
}
