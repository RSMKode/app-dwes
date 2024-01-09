<header class="encabezado">
    <div class="encabezado_contenedor">
        <?=
        pintaEnlace("../index.php", "<h1>App DWES</h1>", false);
        require("form-color.php");
        ?>

        <ul>
            <?php
            switch ($_SESSION["nivel"]) {
                case 0:
                    echo "<li>";
                    echo pintaEnlace(APP_ROOT . "../index.php", "Iniciar sesión");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace(APP_ROOT . "../index.php", "Registrarse");
                    echo "</li>";
                    break;
                case 1:
                    echo "<li>";
                    echo pintaEnlace(APP_ROOT . "../index.php", "Perfil de Usuario");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace(APP_ROOT . "../index.php", "Cerrar sesión");
                    echo "</li>";
                case 2:
                    echo "<li>";
                    echo pintaEnlace(APP_ROOT . "../index.php", "Perfil de Usuario");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace(APP_ROOT . "../index.php", "Cerrar sesión");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace(APP_ROOT . "../index.php", "Cerrar sesión");
                    echo "</li>";
            }
            ?>
        </ul>
    </div>
</header>