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

    <input type=" file" name="pass">

    <br><br>

    Idioma preferente
    <br>
    <select name="idioma">
        <option value="castellano">Castellano</option>
        <option value="ingles">Inglés</option>
        <option value="valenciano">Valenciano</option><br><br>
    </select>
    <br><br>
    Descripcion personal
    <br>
    <textarea cols="50" rows="4" name="text" value="<?= isset($comentario) ? $comentario : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
    <br><br>

    <input type="submit" name="enviar" value="Enviar">
    <input type="reset" name="borrar" value="Borrar datos">





</form>