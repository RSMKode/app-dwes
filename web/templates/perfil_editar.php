<main class="container">
    <?php
    $nombre = $_SESSION["nombre"];
    $f_nacimiento = $_SESSION["f_nacimiento"];
    $foto_perfil = $_SESSION["foto_perfil"];
    $descripcion = $_SESSION["descripcion"];

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

    <h2 class="accent"><?= $_SESSION["email"] ?></h2>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="form_element">
            <label for="nombre">
                Nombre completo<sup>*</sup>
            </label>
            <input type="text" id="nombre" name="nombre" value="<?= isset($nombre) ? $nombre : ""; ?>" placeholder="Introduce aquí tu nombre">
        </div>

        <div class="form_element">
            <label for="password">
                Contraseña<sup>*</sup>
            </label>
            <input type="password" id="password" name="pass" placeholder="**********">
        </div>

        <div class="form_element">
            <label for="fechaNacimiento">
                Fecha de nacimiento<sup>*</sup>
            </label>
            <input type="date" id="fechaNacimiento" name="fechaNacimiento" max="<?= $fechaHoy ?> " value="<?= isset($f_nacimiento) ? $f_nacimiento : date('Y-m-d', time()); ?>">
        </div>

        <div class="form_element">
            <label for="foto">
                Foto de perfil
            </label>
            <?php if ($foto_perfil != "") { ?>
                <img src="<?= $foto_perfil ?>" alt="Foto de Perfil">
            <?php } ?>
            <input type="file" id="foto" name="foto" id="foto" />
        </div>

        <div class="form_element listaHorizontal">
            <label for="idiomas">
                Idioma preferente
            </label>
            <div class="listaHorizontal">
                <?php
                pintaCheck($ids_idiomas, "idiomas")
                ?>
            </div>
        </div>

        <div class="form_element">
            <label for="descripcion">
                Descripción
            </label>
            <textarea id="descripcion" name="descripcion" placeholder="Escribe aquí tu descripción personal"><?= isset($descripcion) ? $descripcion : ""; ?></textarea>
        </div>
        <div class="listaHorizontal">
            <input type="submit" name="enviar" value="Enviar">
            <input type="reset" name="borrar" value="Borrar">
        </div>
    </form>
    <a class="accent" href="index.php?ctl=perfil_usuario">Cancelar</a>

</main>