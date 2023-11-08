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


<form action="alta.php" method="post" enctype="multipart/form-data">
    Selecciona lo que deseas modificar

    <br><br>

    Titulo o nombre de servicio

    <input type="text" name="titul" value="<?= isset($titulo) ? $titulo : ""; ?>"> <br><br>

    Selecciona categoria
    <br>
    <select  name="cat">
        <option value="cat1">categoria1</option>
        <option value="cat2">categoria2</option>
        <option value="cat3">categoria3</option>
    </select>
    <br><br>

    Descripcion del servicio
    <br>
    <textarea cols="50" rows="4" name="comentario"value="<?= isset($comentario) ? $comentario : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
    <br><br>

    ¿Será de pago?
    <br>
    <input type="radio" name="pago" value="si">
    <input type="radio" name="pago" value="no">
    <br><br>

    Introduce precio por hora
    <br>
    <input type="text" name="precio" value="<?= isset($precio) ? $precio : ""; ?>">
    <br><br>

    Ubicacion del servicio
    <br>
    <input type="text" name="ubi" value="<?= isset($ubi) ? $ubi : ""; ?>">
    <br><br>

    Selecciona disponibilidad
    <br>
    <select  name="cat">
        <option value="cat1">Mañanas</option>
        <option value="cat2">Tardes</option>
        <option value="cat3">Noches</option>
    </select>
    <br><br>

    Foto del servicio
    <input type="file"  name="foto">

    <br><br>
    <input type="submit" name="Aceptar" value="enviar">
    <input type="reset" name="borrar" value="Borrar datos">
</form>