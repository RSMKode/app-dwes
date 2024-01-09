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

        Dirección de correo electrónico
        <br>
        <input type="text" name="email" value="<?= isset($email) ? $email : ""; ?>" placeholder="ejemplo@google.com">
        <br>

        Contraseña
        <br>
        <input type="password" name="pass" value="<?= isset($pass) ? $pass : ""; ?>" placeholder="********">
        <br>

        <input type="submit" name="enviar" value="Enviar">
        <input type="reset" name="borrar" value="Borrar">
    </form>
    <a class="accent" href="index.php?ctl=registro">Si no estás registrado, pulsa aqúi</a>
</main>