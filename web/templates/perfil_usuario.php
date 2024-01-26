<?php
$id_user = $_SESSION["id_user"];
$email = $_SESSION["email"];
$pass = $_SESSION["pass"];
$nombre = $_SESSION["nombre"];
$f_nacimiento = $_SESSION["f_nacimiento"];
$foto_perfil = $_SESSION["foto_perfil"];
$descripcion = $_SESSION["descripcion"];
$nivel = $_SESSION["nivel"];
$idiomas = $_SESSION["idiomas"];

print_r($_SESSION["idiomas"]);
?>
<main class="container">
    <p>Bienvenido</p>

    <article class="usuario">
        <h2> <?= $nombre ?> - <span class="accent"><?= $id_user ?></span></h2>
        <p>Email: <?= $email ?></p>
        <p>Nivel: <?= $nivel ?></p>
        <?php if ($foto_perfil) { ?>
            <img src="<?= $foto_perfil ?>" alt="Foto de Perfil">
        <?php } ?>
        <p>Fecha de nacimiento: <?= $f_nacimiento ?></p>
        <?php if ($descripcion) { ?>
            <p>Descripción: <?= $descripcion ?></p>
        <?php } ?>

        <div class="horizontal">
            <?php if ($idiomas) {
            ?>
                <p>Idiomas:</p>
                <?php
                foreach ($idiomas as $idioma) {
                ?>
                    <span><?= $idioma["idioma"] ?></span>

            <?php
                }
            } ?>
        </div>
        <a href="index.php?ctl=perfil_editar">Editar perfil</a>
    </article>

</main>