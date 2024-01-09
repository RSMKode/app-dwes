<?php

/**
 * Crea la cabecera del html con el título indicado, el archivo de css correspondiente
 * y el esquema de color de la página.
 * 
 * @param string $titulo
 * @param string $archivo_css
 * @param string $esquemaColor
 * 
 * @return void
 */
function cabecera(string $titulo = NULL, string $archivo_css = NULL, string $esquemaColor = "Oscuro")
{
    $titulo = (is_null($titulo))
        ? basename(__FILE__)
        : $titulo;
    $cabecera_css = (is_null($archivo_css))
        ? ''
        : '<link rel="stylesheet" type="text/css" href="' . $archivo_css . '">';

    $cabecera = '
            <!DOCTYPE html>
            <html data-theme="' . $esquemaColor . '" lang="es">
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

/**
 * Crea el cierre del html
 */
function pie()
{
    echo '        
                </body>
            </html>
        ';
}

/**
 * Función para pintar un checkbox con los valores que nos pasan por un array

 * @param array $valores
 * @param string $name
 * 
 * @return void
 */
function pintaCheck(array $valores, string $name)
{
    foreach ($valores as $key => $valor) {
        echo '<input type="checkbox" name="' . $name . '[]" value=' . $key . '>' . $valor . 'a';
    };
};

/**
 * Función para pintar un radio button con los valores que nos pasan por un array

 * @param array $valores
 * @param string $name
 * 
 * @return void
 */
function pintaRadio(array $valores, string $name)
{
    foreach ($valores as $key => $valor) {
        echo '<input type="radio" name="' . $name . '" value="' . $valor . '">' . $valor . '<br>';
    };
};

/**
 * Función para pintar un select con los valores que nos pasan por un array

 * @param array $valores
 * @param string $name
 * 
 * @return void
 */
function pintaSelect(array $valores, string $name, bool $esAsociativo = false)
{
    echo "<select name='$name'>";

    foreach ($valores as $key => $valor) {
        if (!$esAsociativo) $key = $valor;
        echo '<option value="' . $key . '">' . $valor . '<br>';
    };
    echo "</select>";
};

/**
 * Función para pintar un enlace con la url y el texto que envuelve el anchor

 * @param string $url
 * @param string $texto
 * @param bool $enParrafo
 * 
 * @return void
 */
function pintaEnlace(string $url, string $texto, bool $enParrafo = true)
{
    return '<a href="' . $url . '">' . $texto . '</a>';
}
