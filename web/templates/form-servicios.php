<?php
if (count($errores) != 0) {
    echo "<p class='errores'>";
    echo "Hay errores en el formulario:<br>";
    foreach ($errores as $error) {
        echo $error;
        echo "<br>";
    }
    echo "</p>";
}
?>


<form action="" method="post" enctype="multipart/form-data">
    Datos del Servicio
    <br>
    <br>

    Titulo o nombre de servicio<sup>*</sup>
    <br>
    <input type="text" name="titulo" value="<?= isset($titulo) ? $titulo : ""; ?>">
    <br>

    Selecciona categoria<sup>*</sup>
    <br>
    <?=
    pintaSelect($categorias, "categoria");
    ?>
    <br>

    Descripcion del servicio<sup>*</sup>
    <br>
    <textarea cols="50" rows="4" name="comentario" value="<?= isset($comentario) ? $comentario : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
    <br>

    ¿Será de pago?<sup>*</sup>
    <br>
    <?=
    pintaRadio($pagos, "pago");
    ?>

    Introduce precio por hora
    <br>
    <input type="text" name="precio" value="<?= isset($precio) ? $precio : ""; ?>">
    <br>

    Ubicacion del servicio<sup>*</sup>
    <br>
    <input type="text" name="ubicacion" value="<?= isset($ubi) ? $ubi : ""; ?>">
    <br>

    Disponibilidad<sup>*</sup>
    <br>
    <?=
    pintaSelect($disponibilidades, "disponibilidad");
    ?>
    <br>

    Foto del servicio
    <br>
    <input type="file" name="fotoServicio">
    <br>

    <input type="submit" name="enviar" value="Enviar">
    <input type="reset" name="borrar" value="Borrar datos">
</form>