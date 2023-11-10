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
    Datos que del servicio
    <br><br>

    Titulo o nombre de servicio<sup>*</sup>
    <input type="text" name="titulo" value="<?= isset($titulo) ? $titulo : ""; ?>"> <br><br>

    Selecciona categoria<sup>*</sup>
    <br>
    <select name="categoria">
        <option value="Categoria 1">Categoria 1</option>
        <option value="Categoria 2">Categoria 2</option>
        <option value="Categoria 3">Categoria 3</option>
    </select>
    <br><br>

    Descripcion del servicio<sup>*</sup>
    <br>
    <textarea cols="50" rows="4" name="comentario" value="<?= isset($comentario) ? $comentario : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
    <br><br>

    ¿Será de pago?<sup>*</sup>
    <br>
    Sí <input type="radio" name="pago" value="Si">
    No <input type="radio" name="pago" value="No">
    <br><br>

    Introduce precio por hora
    <br>
    <input type="text" name="precio" value="<?= isset($precio) ? $precio : ""; ?>">
    <br><br>

    Ubicacion del servicio<sup>*</sup>
    <br>
    <input type="text" name="ubicacion" value="<?= isset($ubi) ? $ubi : ""; ?>">
    <br><br>

    Disponibilidad<sup>*</sup>
    <br>
    <select name="disponibilidad">
        <option value="Mañanas">Mañanas</option>
        <option value="Tardes">Tardes</option>
        <option value="Noches">Noches</option>
        <option value="Completa">Completa</option>
        <option value="Fines de Semana">Fines de semana</option>
    </select>
    <br><br>

    Foto del servicio
    <br>
    <input type="file" name="foto">

    <br><br>
    <input type="submit" name="enviar" value="Enviar">
    <input type="reset" name="borrar" value="Borrar datos">
</form>