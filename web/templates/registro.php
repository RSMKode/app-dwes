<main class="container">
    <?php
    if (isset($params['mensaje'])) {
    ?>
        <p class="exito"><?= $params['mensaje'] ?></p>
    <?php
    }

    if (count($errores) != 0) {

        echo "<ul class='errores'>";
        echo "Hay errores en el formulario:<br>";
        foreach ($errores as $error) {
            echo "<li>";
            echo $error;
            echo "</li>";
        }
        echo "</ul>";
    }
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <label>
            <span>Nombre completo<sup>*</sup></span>
            <input type="text" name="nombre" value="<?= isset($datos_usuario["nombre"]) ? $datos_usuario["nombre"] : ""; ?>" placeholder="Introduce aquí tu nombre">
        </label>
        <label>
            <span>Dirección de correo electrónico<sup>*</sup></span>
            <input type="text" name="email" value="<?= isset($datos_usuario["email"]) ? $datos_usuario["email"] : ""; ?>" placeholder="ejemplo@google.com">
        </label>
        <label>
            <span>Contraseña<sup>*</sup></span>
            <input type="password" name="pass" placeholder="**********">
        </label>
        <label>
            <span>Fecha de nacimiento<sup>*</sup></span>
            <input type="date" name="fechaNacimiento" max="<?= $fechaHoy ?> " value="<?= isset($datos_usuario["f_nacimiento"]) ? $datos_usuario["f_nacimiento"] : date('Y-m-d', time()); ?>">
        </label>
        <label>
            <span> Foto de perfil</span>
            <input type="file" name="foto" id="foto" />
        </label>
        <label>
            <span>Idioma preferente</span>
            <?php
            pintaCheck($ids_idiomas, "idiomas")
            ?>
        </label>
        <label>
            <span>Descripción</span>
            <textarea name="descripcion" value="<?= isset($datos_usuario["descripcion"]) ? $datos_usuario["descripcion"] : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
        </label>
        <div class="horizontal">
            <input type="submit" name="enviar" value="Enviar">
            <input type="reset" name="borrar" value="Borrar">
        </div>
    </form>
    <a class="accent" href="index.php?ctl=inicio_sesion">Si ya estás registrado, pulsa aqúi</a>

</main>