<?php
$servicio = $servicio ? $servicio : $params['servicio'];
?>

<article class="container">
    <h2 class="accent"> <?= $servicio['titulo'] ?></h2>
    <?php if ($servicio['foto_servicio'] != "") { ?>

        <img src="<?= $servicio['foto_servicio'] ?>" alt="Foto del Servicio">
    <?php } ?>
    <p>Precio: <?= $servicio['precio'] ?></p>
    <p>Tipo: <?= TIPOS_IDS[$servicio['tipo']] ?></p>
    <p>Disponibilidades:</p>
    <div class="horizontal">
        <?php
        foreach ($servicio['disponibilidades'] as $disponibilidad) {
        ?>
            <span><?= $disponibilidad["disponibilidad"] ?></span>

        <?php
        }
        ?>
    </div>
    <p>Descripcion: <?= $servicio['descripcion'] ?></p>
    <a href="index.php?ctl=servicio&id_servicio=<?= $servicio['id_servicios'] ?>">Ver más</a>
</article>