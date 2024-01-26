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
        <h2>Datos del Servicio</h2>
        <label>
            <span>Titulo o nombre de servicio<sup>*</sup></span>
            <input type="text" name="titulo" value="<?= isset($datos_servicio["titulo"]) ? $datos_servicio["titulo"] : ""; ?>" placeholder="Servicio">
        </label>

        <label>
            <span>Descripcion del servicio<sup>*</sup></span>
            <textarea cols="50" rows="4" name="descripcion" value="<?= isset($datos_servicio["descripcion"]) ? $datos_servicio["descripcion"] : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
        </label>

        <label>
            <span>Introduce precio por hora</span>
            <input type="text" name="precio" value="<?= isset($datos_servicio["precio"]) ? $datos_servicio["precio"] : ""; ?>" placeholder="10">
        </label>

        <label>
            <span>Selecciona tipo<sup>*</sup></span>
            <?=
            pintaSelect($ids_tipos, "tipo", true);
            ?>
        </label>

        <label>
            <span>Disponibilidades<sup>*</sup></span>
            <div class="horizontal">
                <?=
                pintaCheck($ids_disponibilidades, "disponibilidades");
                ?></div>
        </label>

        <label>
            <span>Foto del servicio</span>
            <input type="file" name="foto_servicio">
        </label>

        <div class="horizontal">
            <input type="submit" name="enviar" value="Enviar">
            <input type="reset" name="borrar" value="Borrar datos">
        </div>
    </form>
</main>