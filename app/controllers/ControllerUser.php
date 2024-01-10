
<?php

class ControllerUser extends Controller
{

    public function inicio_sesion()
    {
        $errores = [];

        if ($_SESSION['nivel'] > 0) {
            header('Location: index.php?ctl=perfil_usuario');
        } else {
            if (isset($_REQUEST['enviar'])) {

                //Sanitizamos
                $email = recoge("email");
                $pass = recoge("pass");

                //Validamos los campos de correo y fecha
                cTexto($email, "email", $errores, "email");
                cTexto($pass, "pass", $errores, "pass", 30, 4);

                if (empty($errores)) {


                    if (self::login($email, $pass, $errores)) {
                        header('Location: index.php?ctl=perfil_usuario');
                    };
                }

                // //Si no se encuentra el usuario en el archivo guardamos un log del fallo de inicio de sesión
                // $horaActual = date("d-m-Y H:i:s");
                // $archivo = fopen($_SERVER["DOCUMENT_ROOT"] . APP_ROOT . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . $rutaArchivos . DIRECTORY_SEPARATOR . "logLogin.txt", "a");
                // fwrite($archivo, $correo . "|" . $pass . "|" . $horaActual . "|" . PHP_EOL);
                // fclose($archivo);

            }

            $params = [
                'titulo' => 'Iniciar sesión',
                'vista' => 'inicio_sesion',
            ];
            require self::$ruta_layout;
        }
    }

    public function cerrar_sesion()
    {
        

        self::cerrarSesion();
        header('Location: index.php');
    }

    public function perfil_usuario()
    {
        self::comprobarNivel1();
        $params = [
            'titulo' => 'Perfil de Usuario',
            'vista' => 'perfil_usuario',
        ];
        require self::$ruta_layout;
    }

    public function registro()
    {
        $params = [
            'titulo' => 'Registro',
            'vista' => 'registro',
        ];

        $idioma = new Idioma();
        $ids_idiomas = $idioma->getIdiomasIds();

        $errores = [];

        if ($_SESSION['nivel'] > 0) {
            header('Location: index.php?ctl=perfil_usuario');
        } else {
            if (isset($_REQUEST['enviar'])) {

                //Sanitizamos
                $datos_usuario["nombre"] = recoge("nombre");
                $datos_usuario["email"] = recoge("email");
                $datos_usuario["pass"] = recoge("pass");
                $datos_usuario["f_nacimiento"] = recoge("fechaNacimiento");
                $datos_usuario["descripcion"] = recoge("descripcion");
                $datos_usuario["idiomas"]  = recogeArray("idiomas");

                //Validamos los campos que no son ficheros
                cTexto($datos_usuario["nombre"], "nombre", $errores, "nombre", 40, 1);
                cTexto($datos_usuario["email"], "email", $errores, "email");
                cTexto($datos_usuario["pass"], "pass", $errores, "pass", 30, 4);
                cFecha($datos_usuario["f_nacimiento"], "fechaNacimiento", $errores, FORMATOS_FECHA[1]);
                cTexto($datos_usuario["descripcion"], "descripcion", $errores, "descripcion", 300, 0);

                //El array keys sirve para pasarle un array con las claves (ids) del array de idiomas
                cCheck($datos_usuario["idiomas"], "idiomas", $errores, array_keys($ids_idiomas), false);

                //Sino ha habido errores en el resto de campos comprobamos el fichero
                if (empty($errores)) {

                    $ruta_fichero = "src" . DIRECTORY_SEPARATOR . RUTA_IMAGENES . DIRECTORY_SEPARATOR . "users";
                    //En este caso la subida de la foto no es obligatoria
                    $datos_usuario["foto_perfil"] = cFile(
                        "foto",
                        $errores,
                        EXTENSIONES_VALIDAS,
                        $ruta_fichero,
                        MAX_FICHERO,
                        false
                    );

                    /*
                    Sino ha habido error en la subida del fichero
                    */
                    if (empty($errores)) {
                        echo ($datos_usuario["foto_perfil"]);
                        $datos_usuario["pass"] = encriptar($datos_usuario["pass"]);

                        $usuario = new Usuario();
                        if ($usuario->addUsuario($datos_usuario, 1)) {
                            unset($datos_usuario);
                            $params['mensaje'] = "Usuario registrado correctamente";
                        }
                    }
                }
            }
            require self::$ruta_layout;
        }
    }
}
