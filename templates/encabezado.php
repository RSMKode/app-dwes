<header class="encabezado">
    <div class="encabezado_contenedor">
        <?=
        pintaEnlace(APP_ROOT . "index.php", "<h1>App DWES</h1>", false);
        require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "templates/form-color.php");
        ?>

        <ul>
            <?php

            if (isset($_SESSION["email"])) {
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "controllers/perfil-usuario.php", "Perfil de Usuario", false);
                echo "</li>";
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "controllers/cerrar-sesion.php", "Cerrar sesión", false);
                echo "</li>";
            } else {
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "controllers/inicio.php", "Iniciar sesión", false);
                echo "</li>";
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "controllers/registro.php", "Registrarse", false);
                echo "</li>";
            }

            ?>
        </ul>
    </div>
</header>