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
        echo '<input type="checkbox" name="' . $name . '[]" id="' . $key . '" value=' . $key . '><label for="' . $key . '">' . $valor . '</label>';
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
        echo '<input type="radio" id="' . $name . '" name="' . $name . '" value="' . $valor . '"><label for="' . $name . '">' . $valor . '</label>';
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
    echo "<select id='$name' name='$name'>";

    foreach ($valores as $key => $valor) {
        if (!$esAsociativo) $key = $valor;
        echo '<option value="' . $key . '">' . $valor;
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
    if ($enParrafo) {
        return '<p><a href="' . $url . '">' . $texto . '</a></p>';
    } else {
        return '<a href="' . $url . '">' . $texto . '</a>';
    }
}

/**
 * Función para crear botones para borrar

 * @param string $url
 * @param string $texto
 * @param bool $enParrafo
 * 
 * @return void
 */
function pintaBotones(array $valores, string $name)
{
    foreach ($valores as $key => $valor) {
        echo "<label >$valor <input class='boton-borrar' type='submit' id='$name' name='$name' value='$key'></label>";
    }
};
