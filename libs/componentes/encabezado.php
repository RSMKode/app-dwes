<header class="encabezado">
    <div class="encabezado_contenedor">
        <?=
        pintaEnlace(APP_ROOT . "src/pages/index.php", "<h1>App DWES</h1>", false);
        require($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . "libs/componentes/form-color.php");
        ?>

        <ul>
            <?php

            if (isset($_SESSION["correo"])) {
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "src/pages/perfil/perfil-usuario.php", "Perfil de Usuario", false);
                echo "</li>";
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "src/pages/perfil/cerrar-sesion.php", "Cerrar sesión", false);
                echo "</li>";
            } else {
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "src/pages/inicio/inicio.php", "Iniciar sesión", false);
                echo "</li>";
                echo "<li>";
                echo pintaEnlace(APP_ROOT . "src/pages/registro/registro.php", "Registrarse", false);
                echo "</li>";
            }

            ?>
        </ul>
    </div>
</header>