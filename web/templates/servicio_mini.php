<?php

?>

<article class="container">
    <h2 class="accent"> <?= $servicio['titulo'] ?></h2>
    <?php if ($servicio['foto_servicio'] != "") { ?>
        <img src="<?= $servicio['foto_servicio'] ?>" alt="Foto del Servicio">
    <?php } ?>
    <p><?= TIPOS_IDS[$servicio['tipo']] ?></p>
    <a href="index.php?ctl=servicio&id_servicio=<?= $servicio['id_servicios'] ?>">Ver más</a>
</article>