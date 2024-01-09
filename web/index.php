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
require("../app/model/classIdioma.php");

const SESION = new Sesion();

//Comprobamos el color de la página
cColor();

$map = [
    /*
    En cada elemento podemos añadir una posición mas que se encargará de otorgar el nivel mínimo para ejecutar la acción
    Puede quedar de la siguiente manera
    'inicio' => array('controller' =>'Controller', 'action' =>'inicio', 'nivel_usuario'=>0)
    */
    'indice' => ['controller' => 'Controller', 'action' => 'indice'],
    'error' => ['controller' => 'Controller', 'action' => 'error'],
    'inicio_sesion' => ['controller' => 'ControllerUser', 'action' => 'inicio_sesion'],
    'registro' => ['controller' => 'ControllerUser', 'action' => 'registro'],
    'lista-usuarios' => ['controller' => 'ControllerUser', 'action' => 'lista-usuarios'],
    'ver' => ['controller' => 'Controller', 'action' => 'ver'],
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
    call_user_func([
        new $controlador['controller'],
        $controlador['action']
    ]);
} else {
    header('Status: 404 Not Found');
    echo '<html><body><h1>Error 404: El controlador <i>' .
        $controlador['controller'] .
        '->' .
        $controlador['action'] .
        '</i> no existe</h1></body></html>';
}

?>
<!-- <h1>App DWES</h1>
<main class="container">
    <ul class="nav">
        <li>
            <a href="controllers/registro.php">Registrarse</a>
        </li>
        <li>
            <a href="controllers/inicio.php">Iniciar sesión</a>
        </li>
        <br>
        <li>
            <a href="controllers/mostrar-usuarios.php">Mostrar usuarios</a>
        </li>
        <br>
        <li>
            <a href="controllers/servicios-lista.php">Mostrar servicios</a>
        </li>
        <li>
            <a href="controllers/servicios-alta.php">Dar de alta un servicio</a>
        </li>
        <br>
    </ul>
</main> -->