<?php

/**
 * Librería con funciones generales y de validación
 * @author Roger, Jonathan
 * 
 */

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

/**
 * funcion sinTildes
 *
 * Elimina caracteres con tilde de las cadenas
 * 
 * @param string $frase
 * @return string
 */
function sinTildes($frase)
{
    $no_permitidas = array(
        "á",
        "é",
        "í",
        "ó",
        "ú",
        "Á",
        "É",
        "Í",
        "Ó",
        "Ú",
        "à",
        "è",
        "ì",
        "ò",
        "ù",
        "À",
        "È",
        "Ì",
        "Ò",
        "Ù"
    );
    $permitidas = array(
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U",
        "a",
        "e",
        "i",
        "o",
        "u",
        "A",
        "E",
        "I",
        "O",
        "U"
    );
    $texto = str_replace($no_permitidas, $permitidas, $frase);
    return $texto;
}

/**
 * Funcion sinEspacios
 * 
 * Elimina los espacios de una cadena de texto
 * 
 * @param string $frase
 * @param string $espacio
 * @return string
 */
function sinEspacios(string $cadena): string
{
    $texto = trim(preg_replace('/ +/', " ", $cadena));
    return $texto;
}

//Compara dos cadenas ignorando mayúsculas y minúsculas y sin tildes ni espacios utilizando las funciones anteriores.
function compCaseEsp(string $cadena1, string $cadena2): int
{
    $newCadena1 = sinTildes(sinEspacios($cadena1));
    $newCadena2 = sinTildes(sinEspacios($cadena2));

    return strcasecmp($newCadena1, $newCadena2);
}

/**
 * Funcion recoge
 * 
 * Sanitiza cadenas de texto
 * 
 * @param string $var
 * @return string
 */
function recoge(string $var): string
{
    if (isset($_REQUEST[$var]) && (!is_array($_REQUEST[$var]))) {
        $tmp = sinEspacios($_REQUEST[$var]);
        $tmp = strip_tags($tmp);
    } else
        $tmp = "";

    return $tmp;
}

/**
 * Funcion recogeArray
 * 
 * Sanitiza arrays
 * 
 * @param string $var
 * @return array
 */

function recogeArray(string $var): array
{
    $array = [];
    if (isset($_REQUEST[$var]) && (is_array($_REQUEST[$var]))) {
        foreach ($_REQUEST[$var] as $valor)
            $array[] = strip_tags(sinEspacios($valor));
    }

    return $array;
}


//Funciones de validación

/**
 * Funcion cTexto
 *
 * Valida una cadena de texto con respecto a una RegEx. Reporta error en un array.
 * Le pasamos cadena, nombre de campo y array de errores y 
 * de manera voluntaria mínimo y máximo de caracteres (si = sería campo no requerido) , 
 * si permitimos o no espacios en nuestra cadena y si la cadena es o no sensible a mayúsculas
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param integer $min
 * @param integer $max
 * @param bool $espacios
 * @param bool $case
 * @return bool
 *
 */
function cTexto(string $text, string $campo, array &$errores, int $max = 30, int $min = 1, bool $espacios = TRUE, bool $case = TRUE)
{
    $case = ($case === TRUE) ? "i" : "";
    $espacios = ($espacios === TRUE) ? " " : "";
    if ((preg_match("/^[a-zñ$espacios]{" . $min . "," . $max . "}$/u$case", sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

function cPass(string $text, string $campo, array &$errores, int $max = 30, int $min = 4, bool $espacios = TRUE, bool $case = TRUE)
{
    $case = ($case === TRUE) ? "i" : "";
    $espacios = ($espacios === TRUE) ? " " : "";
    if ((preg_match("/^[a-zñ0-9-_$espacios]{" . $min . "," . $max . "}$/u$case", sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

function cFecha(string $fecha, string $campo, array &$errores, string $formato)
{
    $fechaArray = explode("-", $fecha);

    if ($formato === FORMATOS_FECHA[0]) {
        $d = $fechaArray[0];
        $m = $fechaArray[1];
        $y = $fechaArray[2];
    } else if ($formato === FORMATOS_FECHA[1]) {
        $d = $fechaArray[2];
        $m = $fechaArray[1];
        $y = $fechaArray[0];
    }

    if (checkdate($m, $d, $y)) return true;

    $errores[$campo] = "Error en el campo $campo";
    return false;
}

function cCorreo(string $text, string $campo, array &$errores)
{

    $regexCorreo = "/^[a-zñÑ][a-z0-9_\.]{2,}@[a-zñÑ\.]{3,}[\.][a-zñÑ]{2,}$/ui";

    if ((preg_match($regexCorreo, sinTildes($text)))) {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo, por favor, introduce un correo con este formato correo@dominio.com";
    return false;
}

/**
 * Funcion cNum
 *
 * Valida que un string sea numerico menor o igual que un número y si es o no requerido
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param bool $requerido
 * @param integer $max
 * @return bool
 */
function cNum(string $num, string $campo, array &$errores, bool $requerido = TRUE, int $max = PHP_INT_MAX)
{
    $cuantificador = ($requerido) ? "+" : "*";
    if ((preg_match("/^[0-9]" . $cuantificador . "$/", $num)) && ($num <= $max)) {

        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cRadio
 *
 * Valida que un string se encuentre entre los valores posibles. Si es requerido o no
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * 
 * @return boolean
 */
function cRadio(string $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{
    if (!$requerido && $text == "") {
        return true;
    }
    if (in_array($text, $valores)) {
        return true;
    }

    $errores[$campo] = "Error en el campo $campo";
    return false;
}

//Funcion de validacion de Select
function cSelect(string $text, string $campo, array &$errores, array $valores, bool $requerido = TRUE): bool
{
    if (!$requerido && $text == "") {
        return true;
    }
    if (in_array($text, $valores)) {
        return true;
    }
    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cCheck
 *
 * Valida que los valores seleccionado en un checkbox array están dentro de los 
 * valores válidos dados en un array. Si es requerido o no
 * 
 * @param array $text
 * @param string $campo
 * @param array $errores
 * @param array $valores
 * @param bool $requerido
 * 
 * @return boolean
 */

function cCheck(array $arr, string $campo, array &$errores, array $valores, bool $requerido = TRUE)
{

    if (($requerido) && (count($arr) == 0)) {
        $errores[$campo] = "Error en el campo $campo";
        return false;
    }
    foreach ($arr as $valor) {
        if (!in_array($valor, $valores)) {
            $errores[$campo] = "Error en el campo $campo, no existe el valor: $valor";
            return false;
        }
    }
    return true;
}

/**
 * Funcion cFile
 * 
 * Valida la subida de un archivo a un servidor.
 *
 * @param string $nombre
 * @param array $extensiones_validas
 * @param string $directorio
 * @param integer $max_file_size
 * @param array $errores
 * @param boolean $required
 * @return boolean|string
 */
function cFile(string $nombre, array &$errores, array $extensionesValidas, string $directorio, int  $max_file_size,  bool $required = TRUE)
{
    // Caso especial que el campo de file no es requerido y no se intenta subir ningun archivo
    if ((!$required) && $_FILES[$nombre]['error'] === 4)
        return "";
    // En cualquier otro caso se comprueban los errores del servidor 
    if ($_FILES[$nombre]['error'] != 0) {
        $errores[$nombre] = "Error al subir el archivo " . $nombre . ". Prueba de nuevo";
        return false;
    } else {

        //Guardamos nombre del fichero en el servidor
        $nombreArchivo = strip_tags($_FILES[$nombre]['name']);

        //Guardamos directorio temporal donde se guarda el fichero
        $directorioTemp = $_FILES[$nombre]['tmp_name'];
        echo "directorioTemp es $directorioTemp";

        //Calculamos el tamaño del fichero
        $tamanyoFile = filesize($directorioTemp);

        //Extraemos la extensión del fichero, desde el último punto. Si hubiese doble extensión, no la tendría en cuenta.
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));

        //Comprobamos la extensión del archivo dentro de la lista que hemos definido al principio
        if (!in_array($extension, $extensionesValidas)) {
            $errores[$nombre] = "La extensión del archivo no es válida";
            return false;
        }
        //Comprobamos el tamaño del archivo
        if ($tamanyoFile > $max_file_size) {
            $errores[$nombre] = "La imagen debe de tener un tamaño inferior a $max_file_size kb";
            return false;
        }

        // Almacenamos el archivo en ubicación definitiva si no hay errores ( al compartir array de errores TODOS LOS ARCHIVOS tienen que poder procesarse para que sea exitoso. Si cualquiera da error, NINGUNO  se procesa)

        if (empty($errores)) {
            //Comprobamos si el directorio pasado es válido
            if (is_dir($directorio)) {
                /*
                 Tenemos que buscar un nombre único para guardar el fichero de manera definitiva.
                 Podemos hacerlo de diferentes maneras, en este caso se hace añadiendo microtime() al nombre del fichero si ya existe un archivo guardado con ese nombre.
                 */
                $nombreArchivo = is_file($directorio . DIRECTORY_SEPARATOR . $nombreArchivo) ? time() . $nombreArchivo : $nombreArchivo;
                $nombreCompleto = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;
                //Movemos el fichero a la ubicación definitiva.
                if (move_uploaded_file($directorioTemp, $nombreCompleto)) {
                    //Si todo es correcto devuelve la ruta y nombre del fichero como se ha guardado
                    return $nombreCompleto;
                } else {
                    $errores["imagen"] = "Ha habido un error en la subida del fichero";
                    return false;
                }
            } else {
                $errores["imagen"] = "Ha habido un error al subir el fichero";
                return false;
            }
        }
    }
}
