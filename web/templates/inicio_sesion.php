<main class="container">
    <?php
    if (count($errores) != 0) {
        echo "<ul class='accent'>";
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
            <span>Dirección de correo electrónico<sup>*</sup></span>
            <input type="text" name="email" value="<?= isset($email) ? $email : ""; ?>" placeholder="ejemplo@google.com">
        </label>
        <label>
            <span>Contraseña<sup>*</sup></span>
            <input type="password" name="pass" placeholder="********">
        </label>

        <div class="horizontal">
            <input type="submit" name="enviar" value="Enviar">
            <input type="reset" name="borrar" value="Borrar">
        </div>
    </form>
    <a class="accent" href="index.php?ctl=registro">Si no estás registrado, pulsa aquí</a>
</main>