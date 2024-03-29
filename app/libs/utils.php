<?php

/**
 * Librería con funciones generales y de validación
 * @author Roger, Jonathan, Heike Bonilla
 * 
 */

/**
 * funcion sinTildes
 *
 * Elimina caracteres con tilde de las cadenas
 * 
 * @param string $frase
 * @return string
 */


require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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
function recoge(string $campo): string
{
    if (isset($_REQUEST[$campo]) && (!is_array($_REQUEST[$campo]))) {
        $tmp = sinEspacios($_REQUEST[$campo]);
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

function recogeArray(string $campo): array
{
    $array = [];
    if (isset($_REQUEST[$campo]) && (is_array($_REQUEST[$campo]))) {
        foreach ($_REQUEST[$campo] as $valor)
            $array[] = strip_tags(sinEspacios($valor));
    }

    return $array;
}


//Funciones de validación

/**
 * Funcion cTexto
 *
 * Valida una cadena de texto con respecto a una RegEx.
 * Reporta error en un array.
 * Le pasamos cadena, nombre de campo, array de errores, tipo y 
 * de manera voluntaria mínimo y máximo de caracteres (si = sería campo no requerido) , 
 * si permitimos o no espacios en nuestra cadena y si la cadena es o no sensible a mayúsculas
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param string $tipo
 * @param integer $min
 * @param integer $max
 * @param bool $espacios
 * @param bool $case
 * @return bool
 *
 */
function cTexto(string $text, string $campo, array &$errores, string $tipo, int $max = 30, int $min = 1, bool $espacios = TRUE, bool $case = TRUE)
{
    $case = ($case === TRUE) ? "i" : "";
    $espacios = ($espacios === TRUE) ? " " : "";
    switch ($tipo) {
        case "nombre":
            $regexp = "/^[a-zñÑ$espacios]{" . $min . "," . $max . "}$/u$case";
            break;

        case "token":
            $regexp = "/^[a-zñÑ0-9-]{" . $min . "," . $max . "}$/u$case";
            break;

        case "email":
            $regexp = "/^[a-zñÑ][a-z0-9_\.]{2,}@[a-zñÑ\.]{3,}[\.][a-zñÑ]{2,}$/ui";
            break;

        case "pass":
            $regexp = "/^[a-zñÑ0-9-_@$espacios]{" . $min . "," . $max . "}$/u$case";
            break;

        case "descripcion":
            $regexp = "/^[a-zñÑ0-9-\.,;$espacios]{" . $min . "," . $max . "}$/u$case";
            break;

        case "ubi":
            //$regexp = "/^[A-Za-z0-9\s,.ºª\/-]+,\s*(\d{1,3}(?:\s*[A-Za-z])?)(?:,\s*[Pp]iso\s*\d{1,2}(?:\s*[A-Za-z])?)?(?:,\s*[Pp]uerta\s*\d{1,3}(?:\s*[A-Za-z])?)?,\s*\d{5}$/$espacios]{" . $min . "," . $max . "}$/u$case";
            $regexp = "/^[a-zñÑ0-9-\/\.,;$espacios]{" . $min . "," . $max . "}$/u$case";
            break;
    }

    if ((preg_match($regexp, sinTildes($text)))) {
        return true;
    }

    $errores[$campo] = "Error en el campo $campo";
    return false;
}

/**
 * Funcion cFecha
 *
 * Valida una fecha en función de 2 formatos posibles definidos en config.
 * Además comprueba si el usuario es mayor de edad
 * 
 * @param string $text
 * @param string $campo
 * @param array $errores
 * @param string $formato
 * @return bool
 *
 */
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

    $fechaNacSegundos = strtotime($fecha);
    $edadEnSegundos = time() - $fechaNacSegundos;
    $mayoriaEdad = 60 * 60 * 24 * 365 * 18;

    if ($edadEnSegundos >= $mayoriaEdad) {
        if (checkdate($m, $d, $y)) {
            return true;
        } else {
            $errores[$campo] = "Error en el campo $campo";
        };
    } else {
        $errores[$campo] = "No puedes registrarte, eres menor de 18 años";
    }
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
    if (in_array($text, array_keys($valores))) {
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

/**
 * Funcion cInactividad
 * 
 * Comprueba la inactividad de un usuario que ha iniciado sesión
 *
 * @param int $segundos
 * 
 * @return void
 */
function cInactividad(int $segundos = 60 * 30): void
{
    if (isset($_SESSION["momentoLogin"])) {

        if (time() > $_SESSION["momentoLogin"] + $segundos) {
            header("Location:" . APP_ROOT . "controllers/cerrar-sesion.php");
        } else {
            $_SESSION["momentoLogin"] = time();
        }
    }
}

/**
 * Funcion regenerarSesion
 * 
 * Regenera el id de sesión
 *
 * @param int $segundos
 * 
 * @return void
 */
function regenerarSesion(int $segundos = 60 * 5): void
{
    if (isset($_SESSION["momentoLogin"])) {
        if (time() > $_SESSION["momentoLogin"] + $segundos) {
            session_regenerate_id(true);
        }
    }
}

/**
 * Funcion cIP
 * 
 * Comprueba que la ip actual sea la misma que la del inicio de sesión
 * 
 * @return void
 */
function cIP()
{
    if (isset($_SESSION["ip"])) {

        if ($_SESSION["ip"] != $_SERVER["REMOTE_ADDR"]) {
            header("Location:" . APP_ROOT . "controllers/cerrar-sesion.php");
        }
    }
}

/**
 * Funcion cColor
 * 
 * Comprueba el color de la página preferente por el usuario.
 * Si no existe la cookie, la crea con el color predeterminado.
 * Si existe y se detecta un nuevo esquema de color, se cambia el valor de la cookie.
 * 
 * @return void
 */
function cColor()
{
    if (!isset($_COOKIE['esquemaColor'])) {
        setcookie('esquemaColor', TEMAS[1], path: "/");
        header('Refresh:0');
        return;
    } else {
        if (isset($_POST['nuevoEsquemaColor'])) {
            setcookie('esquemaColor', $_POST['nuevoEsquemaColor'], path: "/");
            header('Refresh:0');
        }
        return;
    }
}

function sendEmailToken($email, $token)
{
    // Crea una instancia de PHPMailer
    $mail = new PHPMailer();

    try {
        // Configura el servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'abastospruebajon@gmail.com';
        $mail->Password = 'jsdg nxpf vuhi xesd';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        // Configura los destinatarios
        $mail->setFrom('abastospruebajon@gmail.com', 'APP-DWES');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Verifica tu email';
        $mail->Body = "<p>Empieza tu experiencia APP-DWES. Haz click en el siguiente enlace para confirmar tu cuenta de correo electrónico:</p>
                        <a href='http://localhost/app-dwes/web/index.php?ctl=confirmar_token&token=$token'>Confirmar cuenta</a>";
        // Enviar el correo
        $mail->send();
    } catch (Exception $e) {
        return false;
    }
}
