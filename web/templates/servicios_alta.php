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
        Datos del Servicio
        <br>
        <br>

        Titulo o nombre de servicio<sup>*</sup>
        <br>
        <input type="text" name="titulo" value="<?= isset($datos_servicio["titulo"]) ? $datos_servicio["titulo"] : ""; ?>">
        <br>

        Descripcion del servicio<sup>*</sup>
        <br>
        <textarea cols="50" rows="4" name="descripcion" value="<?= isset($datos_servicio["descripcion"]) ? $datos_servicio["descripcion"] : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
        <br>

        Introduce precio por hora
        <br>
        <input type="text" name="precio" value="<?= isset($datos_servicio["precio"]) ? $datos_servicio["precio"] : ""; ?>">
        <br>

        Selecciona tipo<sup>*</sup>
        <br>
        <?=
        pintaSelect($ids_tipos, "tipo", true);
        ?>
        <br>

        Disponibilidades<sup>*</sup>
        <br>
        <?=
        pintaCheck($ids_disponibilidades, "disponibilidades");
        ?>
        <br>

        Foto del servicio
        <br>
        <input type="file" name="foto_servicio">
        <br>

        <input type="submit" name="enviar" value="Enviar">
        <input type="reset" name="borrar" value="Borrar datos">
    </form>
</main>