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
<form action="" method="post">
    Nombre completo<sup>*</sup>
    <br>
    <input type="text" name="nombre" value="<?= isset($nombre) ? $nombre : ""; ?>" placeholder="Introduce aquí tu nombre">
    <br>

    Dirección de correo electrónico<sup>*</sup>
    <br>
    <input type="text" name="correo" value="<?= isset($correo) ? $correo : ""; ?>" placeholder="ejemplo@google.com">
    <br>

    Contraseña<sup>*</sup>
    <br>
    <input type="password" name="pass" value="<?= isset($pass) ? $pass : ""; ?>" placeholder="**********">
    <br>

    Fecha de nacimiento<sup>*</sup>
    <br>
    <input type="date" name="fechaNacimiento" max="<?= $fechaHoy ?> " value="<?= isset($fechaNacimiento) ? $fechaNacimiento : $fechaHoy; ?>">
    <br>

    Foto de perfil
    <br>
    <input type="file" name="foto" id="foto" /><br>
    <br>

    Idioma preferente
    <br>
    <select name="idioma">
        <option value="castellano">Castellano</option>
        <option value="ingles">Inglés</option>
        <option value="valenciano">Valenciano</option>
    </select>
    <br>
    Comentario
    <br>
    <textarea name="comentario" value="<?= isset($comentario) ? $comentario : ""; ?> " placeholder="Escribe aquí tu descripción personal"></textarea>
    <br>

    <input type="submit" name="enviar" value="Enviar">
    <input type="reset" name="borrar" value="Borrar">
</form>