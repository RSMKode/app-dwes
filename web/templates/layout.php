<!DOCTYPE html>
<html data-theme="<?= $_COOKIE["esquemaColor"] ?>" lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title><?= $params["titulo"] ?></title>
</head>

<body>
    <?php
    require("encabezado.php")
    ?>
    <h1><?= $params["titulo"] ?></h1>


    <?php
    require($params["vista"] . ".php");
    ?>

</body>

</html>