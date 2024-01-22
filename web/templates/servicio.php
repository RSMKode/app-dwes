<?php

?>

<article class="usuario">
    <h2 class="accent"> <?= $servicio['titulo'] ?></h2>
    <img src="<?= $servicio['foto_servicio'] ?>" alt="Foto del Servicio">
    <p>Precio: <?= $servicio['precio'] ?></p>
    <p>Tipo: <?= TIPOS_IDS[$servicio['tipo']] ?></p>
    <ul>Disponibilidades:
        <?php foreach ($servicio['disponibilidades'] as $disponibilidad) {
            echo "<li>$disponibilidad</li>";
        } ?>
    </ul>
    <p>Descripcion: <?= $servicio['descripcion'] ?></p>
    <a href="index.php?ctl=servicios_editar&id_servicio=<?= $servicio['id_servicio'] ?>">Editar servicio</a>
</article>