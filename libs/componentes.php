<?php

//Crea la cabecera del html con el título indicado
function cabecera(string $titulo = NULL, string $archivo_css = NULL)
{
    $titulo = (is_null($titulo))
        ? basename(__FILE__)
        : $titulo;
    $cabecera_css = (is_null($archivo_css))
        ? ''
        : '<link rel="stylesheet" type="text/css" href="' . $archivo_css . '">';

    $cabecera = '
            <!DOCTYPE html>
            <html lang="es">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial scale=1.0">
                    ' . $cabecera_css . '
                    <title>' . $titulo . '</title>
                </head>
                <body>
        ';
    echo $cabecera;
}

// Crea el cierre del html
function pie()
{
    echo '        
                </body>
            </html>
        ';
}

// Función para pintar un checkbox con los valores que nos pasan por un array

function pintaCheck(array $valores, string $name)
{
    foreach ($valores as $key => $valor) {
        echo '<input type="checkbox" name="' . $name . '[]" value=' . $valor . '>' . $valor;
    };
};

function pintaRadio(array $valores, string $name)
{
    foreach ($valores as $key => $valor) {
        echo '<input type="radio" name="' . $name . '" value="' . $valor . '">' . $valor . '<br>';
    };
};

function pintaSelect(array $valores, string $name)
{
    echo "<select name='$name'>";

    foreach ($valores as $key => $valor) {
        echo '<option value="' . $valor . '">' . $valor . '<br>';
    };
    echo "</select>";
};

// function botonCerrarSesion($rutaLocation)
// {
//     echo "
//         <form action='' method='post'>
//         <input type='submit' name='cerrarSesion' value='Cerrar Sesión'>
//         </form>
//         ";

//     if (isset($_POST['cerrarSesion'])) {
//         session_destroy();
//         header("location:$rutaLocation");
//     }
// }
