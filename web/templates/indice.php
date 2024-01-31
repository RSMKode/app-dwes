<main class="container">
    <a href="/app-dwes/web/pruebas.php">PRUEBAS</a>

    <?php

    //muestra todos los servicios menos los propios

    if ($params['servicios']) {
        foreach ($params['servicios'] as $servicio) {
            if (!isset($_SESSION["id_user"]) || $_SESSION["id_user"] != $servicio["id_user"])
                require 'templates/servicio_mini.php';
        }
    }
    ?>
</main>