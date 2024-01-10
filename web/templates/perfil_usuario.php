<?php
$id_user = $_SESSION["id_user"];
$email = $_SESSION["email"];
$pass = $_SESSION["pass"];
$nombre = $_SESSION["nombre"];
$f_nacimiento = $_SESSION["f_nacimiento"];
$foto_perfil = $_SESSION["foto_perfil"];
$descripcion = $_SESSION["descripcion"];
$nivel = $_SESSION["nivel"];
?>

<main class="container">
    <p>Bienvenido</p>

    <article class="usuario">
        <h2> <?= $nombre ?> - <span class="accent"><?= $id_user ?></span></h2>
        <p>Email: <?= $email ?></p>
        <p>Nivel: <?= $nivel ?></p>
        <img src="<?= $foto_perfil ?>" alt="Foto de Perfil">
        <p>Fecha de nacimiento: <?= $f_nacimiento ?></p>
        <p>Descripcion: <?= $descripcion ?></p>
        <a href="index.php?ctl=perfil_editar">Editar perfil</a>
    </article>

</main>