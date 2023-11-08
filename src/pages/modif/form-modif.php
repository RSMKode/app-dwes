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


<form action="modif.php" method="post" enctype="multipart/form-data">
    Selecciona lo que deseas modificar

    <br><br>

    Contraseña

    <input type="password" name="pass" value="<?= isset($pass) ? $pass : ""; ?>" placeholder="**********""> <br><br>

    Foto de perfil

    <input type="file"  name="pass">

    <br><br>

    Idioma preferente
    <br>
    <select  name="idioma">
        <option value="en">Ingles</option>
        <option value="val">Valenciano</option><br><br>
        <option value="es">Español</option>
    </select>
    <br><br>
    Descripcion personal
    <br>
    <textarea cols="50" rows="4" name="text"value="<?= isset($comentario) ? $comentario : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
    <br><br>

    <input type="submit" name="bAceptar" value="Enviar">
    <input type="reset" name="borrar" value="Borrar datos">





</form>
