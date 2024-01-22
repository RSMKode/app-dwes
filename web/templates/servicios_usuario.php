<main class="container">
    <?php
    if (empty($params['servicios'])) {
    ?>
        <p>Todavía no tienes servicios creados</p>
        <a href="http://localhost/app-dwes/web/index.php?ctl=servicios_alta">Crea un servicio</a>
    <?php
    } else {
    ?>
        <p>Bienvenido</p>
    <?php
        foreach ($params['servicios'] as $servicio) {
            require 'templates/servicio.php';
        }
    };
    ?>
</main>