<?php ob_start() ?>

<h1><?php echo $params['alimentos']['nombre'] ?></h1>
<table border="1">

<tr>
<td>Energía</td>
<td><?php echo $params['alimentos']['energia'] ?></td>

</tr>
<tr>
<td>Proteina</td>
<td><?php echo $params['alimentos']['proteina']?></td>

</tr>
<tr>
<td>Hidratos de Carbono</td>
<td><?php echo $params['alimentos']['hidratocarbono']?></td>

</tr>
<tr>
<td>Fibra</td>
<td><?php echo $params['alimentos']['fibra']?></td>

</tr>
<tr>
<td>Grasa total</td>
<td><?php echo $params['alimentos']['grasatotal']?></td>

</tr>

</table>


<?php $contenido = ob_get_clean() ?>

<?php include 'layout.php' ?>
