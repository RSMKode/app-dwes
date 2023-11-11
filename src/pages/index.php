<?php
//Libreria de componentes
require("../../libs/componentes.php");
// Libreria de funciones de validación
require("../../libs/utils.php");
//De config.php leeremos las variables comunes
require("../../libs/config.php");

cabecera("App DWES", "../styles.css");
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
        <li><a href="<?= ROOT ?>/src/pages/inicio/inicio.php">PRUEBA RUTA ABSOLUTA</a></li>
    </ul>
</main>

<?php
pie();
?>