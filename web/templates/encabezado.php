<header class="encabezado">
    <div class="encabezado_contenedor">
        <?=
        pintaEnlace("index.php", "<h1>App DWES</h1>", false);
        require("form-color.php");
        ?>

        <h2><?= $_SESSION['nivel'] ?></h2>

        <ul>
            <?php
            switch ($_SESSION["nivel"]) {
                case 0:
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=inicio_sesion", "Iniciar sesión");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=registro", "Registrarse");
                    echo "</li>";
                    break;
                case 1:
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=servicios_usuario", "Mis servicios");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=servicios_alta", "Crear servicio");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=perfil_usuario", "Perfil de Usuario");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=cerrar_sesion", "Cerrar sesión");
                    echo "</li>";
                    break;
                case 2:
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=servicios_usuario", "Mis servicios");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=servicios_alta", "Crear servicio");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=perfil_usuario", "Perfil de Usuario");
                    echo "</li>";
                    echo "<li>";
                    echo pintaEnlace("index.php?ctl=cerrar_sesion", "Cerrar sesión");
                    echo "</li>";
                    break;
            }
            ?>
        </ul>
    </div>
</header>