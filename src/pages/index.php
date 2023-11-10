<?php
require("../../libs/utils.php");

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
    </ul>
</main>

<?php
pie();
?>