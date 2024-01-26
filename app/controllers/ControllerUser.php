
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
                    $sesion = Sesion::getInstance();

                    if ($sesion->login($email, $pass, $errores)) {
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
        $sesion = Sesion::getInstance();
        $sesion->cerrarSesion();
        header('Location: index.php');
    }

    public function perfil_usuario()
    {
        $params = [
            'titulo' => 'Perfil de Usuario',
            'vista' => 'perfil_usuario',
        ];
        require self::$ruta_layout;
    }

    public function admin()
    {
        $errores = [];
        if (isset($_REQUEST['enviar']) || isset($_REQUEST['eliminar_idioma']) || isset($_REQUEST['eliminar_disponibilidad'])) {

            //Sanitizamos
            $admin["idioma"] = recoge("idioma");
            $admin["disponibilidad"] = recoge("disponibilidad");

            $admin["eliminar_idioma"] = recoge("eliminar_idioma");
            $admin["eliminar_disponibilidad"] = recoge("eliminar_disponibilidad");

            cTexto($admin["idioma"], "idioma", $errores, "nombre", 40, 0);
            cTexto($admin["disponibilidad"], "disponibilidad", $errores, "descripcion", 40, 0);

            cNum($admin["eliminar_idioma"], "eliminar_disponibilidad", $errores, false);
            cNum($admin["eliminar_disponibilidad"], "eliminar_disponibilidad", $errores, false);

            if (empty($errores)) {
                $idioma = new Idioma();
                $disponibilidad = new Disponibilidad();

                if ($admin["idioma"]) $idioma->addIdioma($admin["idioma"]);

                if ($admin["disponibilidad"]) $disponibilidad->addDisponibilidad($admin["disponibilidad"]);

                if ($admin["eliminar_idioma"]) $idioma->deleteIdioma($admin["eliminar_idioma"]);
                if ($admin["eliminar_disponibilidad"]) $disponibilidad->deleteDisponibilidad($admin["eliminar_disponibilidad"]);

                header("location=index.php?ctl=admin");
            }
        }

        $params = [
            'titulo' => 'Panel de Administrador',
            'vista' => 'admin',
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
                        if ($usuario->getUsuario($datos_usuario["email"])) {
                            $errores["email"] = "El email ya está registrado";
                        } else {
                            if ($usuario->addUsuario($datos_usuario, 1)) {
                                unset($datos_usuario);
                                $params['mensaje'] = "Usuario registrado correctamente";
                            }
                        }
                    }
                }
            }
            require self::$ruta_layout;
        }
    }

    public function perfil_editar()
    {
        $params = [
            'titulo' => 'Editar Perfil',
            'vista' => 'perfil_editar',
        ];

        $idioma = new Idioma();
        $ids_idiomas = $idioma->getIdiomasIds();

        $errores = [];

        if (isset($_REQUEST['enviar'])) {

            //Sanitizamos
            $datos_usuario["nombre"] = recoge("nombre");
            $datos_usuario["pass"] = recoge("pass");
            $datos_usuario["f_nacimiento"] = recoge("fechaNacimiento");
            $datos_usuario["descripcion"] = recoge("descripcion");
            $datos_usuario["idiomas"]  = recogeArray("idiomas");

            //Validamos los campos que no son ficheros
            cTexto($datos_usuario["nombre"], "nombre", $errores, "nombre", 40, 1);
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
                    $datos_usuario["pass"] = encriptar($datos_usuario["pass"]);
                    $datos_usuario["id_user"] = $_SESSION['id_user'];
                    $datos_usuario["email"] = $_SESSION['email'];
                    if ($datos_usuario["foto_perfil"] == "") {
                        $datos_usuario["foto_perfil"] = $_SESSION['foto_perfil'];
                    }

                    $usuario = new Usuario();
                    $sesion = Sesion::getInstance();

                    $nivel = $_SESSION['nivel'];
                    if ($usuario->updateUsuario($datos_usuario, $nivel)) {

                        $mensaje = "Usuario modificado correctamente";

                        $_SESSION["id_user"] = $datos_usuario["id_user"];
                        $_SESSION["email"] = $datos_usuario["email"];
                        $_SESSION["pass"] = $datos_usuario["pass"];
                        $_SESSION["nombre"] = $datos_usuario["nombre"];
                        $_SESSION["f_nacimiento"] = $datos_usuario["f_nacimiento"];
                        $_SESSION["foto_perfil"] = $datos_usuario["foto_perfil"];

                        $idioma = new Idioma();
                        $idiomas_ids = $idioma->getIdiomasIds();
                        $idiomas = [];
                        foreach ($datos_usuario["idiomas"] as $id_idioma) {
                            $idiomas[] = ["id_idioma" => $id_idioma, "idioma" => $idiomas_ids[$id_idioma]];
                        }

                        $_SESSION["idiomas"] = $idiomas;
                        $_SESSION["descripcion"] = $datos_usuario["descripcion"];
                        $_SESSION["nivel"] = $nivel;
                        $_SESSION["ulitma_actividad"] = time();
                        $_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];

                        header("Location:index.php?ctl=perfil_usuario&mensaje=$mensaje");
                    }
                }
            }
        }
        require self::$ruta_layout;
    }
}
