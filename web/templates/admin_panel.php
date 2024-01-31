<section class="horizontal">
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
            <span>Idioma</span>
            <input type="text" name="idioma" placeholder="Euskera">
        </label>
        <label>
            <span>Disponibilidad</span>
            <input type="type" name="disponibilidad" placeholder="Fin de semana">
        </label>

        <div class="horizontal">
            <input type="submit" name="enviar" value="Enviar">
            <input type="reset" name="borrar" value="Borrar">
        </div>

        <div class="borrar">
            <p>Eliminar Idiomas:</p>
            <?php
            pintaBotones($params["array_idiomas"], "eliminar_idioma")
            ?>
            <p>Eliminar Disponibilidades:</p>
            <?php
            pintaBotones($params["array_disponibilidades"], "eliminar_disponibilidad")
            ?>
        </div>
    </form>
</section>