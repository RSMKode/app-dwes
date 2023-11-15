<?php
//Variables y constantes comunes
require("/app-dwes-roger-jonathan/libs/config.php");
//Libreria de funciones de validación
require(ROOT . "libs/utils.php");
//Libreria de componentes
require(ROOT . "libs/componentes.php");

session_start();
//Se comprueba inactividad, que sea la misma ip de inicio de sesión, y se regenera el id si han pasado 5 minutos
cInactividad($inactivityTime);
cIP();
regenerarSesion();
//Comprobamos el color de la página
cColor();
$esquemaColor = $_COOKIE['esquemaColor'];

cabecera("App DWES", $rutaEstilos, $esquemaColor);
require(ROOT . "libs/componentes/encabezado.php");
?>
<h1>App DWES</h1>
<main class="container">
    <ul class="nav">
        <li><a href="./registro/registro.php">Registrarse</a></li>
        <li><a href="./inicio/inicio.php">Iniciar sesión</a></li>
        <br>
        <li><a href="./inicio/mostrar-usuarios.php">Mostrar usuarios</a></li>
        <br>
        <li><a href="./servicios/mostrar-servicios.php">Mostrar servicios</a></li>
        <li><a href="./servicios/servicios-alta.php">Dar de alta un servicio</a></li>
        <br>
    </ul>
</main>

<?php
pie();
?>