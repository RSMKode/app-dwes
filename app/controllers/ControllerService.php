
<?php

class ControllerService extends Controller
{

    public function servicios_usuario()
    {
        $id_user = $_SESSION['id_user'];
        $servicio = new Servicio();
        $servicios = $servicio->getServiciosUser($id_user);

        $params = [
            'titulo' => 'Servicios del Usuario',
            'vista' => 'servicios_usuario',
            'servicios' => $servicios
        ];
        require self::$ruta_layout;
    }

    public function servicios_alta()
    {
        $params = [
            'titulo' => 'Registrar servicio',
            'vista' => 'servicios_alta',
        ];

        $disponibilidad = new Disponibilidad();
        $ids_disponibilidades = $disponibilidad->getDisponibilidadesIds();

        $ids_tipos = [1 => "Categoria 1", 2 => "Categoria 2", 3 => "Categoria 3"];

        $errores = [];

        if (isset($_REQUEST['enviar'])) {

            //Sanitizamos
            $datos_servicio["titulo"] = recoge("titulo");
            $datos_servicio["descripcion"] = recoge("descripcion");
            $datos_servicio["precio"] = recoge("precio");
            $datos_servicio["tipo"] = recoge("tipo");
            $datos_servicio["disponibilidades"]  = recogeArray("disponibilidades");

            //Validamos los campos que no son ficheros
            cTexto($datos_servicio["titulo"], "titulo", $errores, "nombre", 40, 1);
            cTexto($datos_servicio["descripcion"], "descripcion", $errores, "descripcion", 300, 0);
            cNum($datos_servicio["precio"], "precio", $errores);
            cSelect($datos_servicio["tipo"], "tipo", $errores, $ids_tipos);

            //El array keys sirve para pasarle un array con las claves (ids) del array de idiomas
            cCheck($datos_servicio["disponibilidades"], "disponibilidades", $errores, array_keys($ids_disponibilidades), false);

            //Sino ha habido errores en el resto de campos comprobamos el fichero
            if (empty($errores)) {

                $ruta_fichero = "src" . DIRECTORY_SEPARATOR . RUTA_IMAGENES . DIRECTORY_SEPARATOR . "services";
                //En este caso la subida de la foto no es obligatoria
                $datos_servicio["foto_servicio"] = cFile(
                    "foto_servicio",
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
                    echo ($datos_servicio["foto_servicio"]);
                    $datos_servicio["id_user"] = $_SESSION["id_user"];

                    $servicio = new Servicio();
                    if ($servicio->addServicio($datos_servicio)) {
                        unset($datos_servicio);
                        $params['mensaje'] = "Servicio registrado correctamente";
                    }
                }
            }
        }
        require self::$ruta_layout;
    }

    // public function perfil_editar()
    // {
    //     $params = [
    //         'titulo' => 'Editar Perfil',
    //         'vista' => 'perfil_editar',
    //     ];

    //     $idioma = new Idioma();
    //     $ids_idiomas = $idioma->getIdiomasIds();

    //     $errores = [];

    //     if (isset($_REQUEST['enviar'])) {

    //         //Sanitizamos
    //         $datos_usuario["nombre"] = recoge("nombre");
    //         $datos_usuario["pass"] = recoge("pass");
    //         $datos_usuario["f_nacimiento"] = recoge("fechaNacimiento");
    //         $datos_usuario["descripcion"] = recoge("descripcion");
    //         $datos_usuario["idiomas"]  = recogeArray("idiomas");

    //         //Validamos los campos que no son ficheros
    //         cTexto($datos_usuario["nombre"], "nombre", $errores, "nombre", 40, 1);
    //         cTexto($datos_usuario["pass"], "pass", $errores, "pass", 30, 4);
    //         cFecha($datos_usuario["f_nacimiento"], "fechaNacimiento", $errores, FORMATOS_FECHA[1]);
    //         cTexto($datos_usuario["descripcion"], "descripcion", $errores, "descripcion", 300, 0);

    //         //El array keys sirve para pasarle un array con las claves (ids) del array de idiomas
    //         cCheck($datos_usuario["idiomas"], "idiomas", $errores, array_keys($ids_idiomas), false);

    //         //Sino ha habido errores en el resto de campos comprobamos el fichero
    //         if (empty($errores)) {

    //             $ruta_fichero = "src" . DIRECTORY_SEPARATOR . RUTA_IMAGENES . DIRECTORY_SEPARATOR . "users";
    //             //En este caso la subida de la foto no es obligatoria
    //             $datos_usuario["foto_perfil"] = cFile(
    //                 "foto",
    //                 $errores,
    //                 EXTENSIONES_VALIDAS,
    //                 $ruta_fichero,
    //                 MAX_FICHERO,
    //                 false
    //             );

    //             /*
    //                 Sino ha habido error en la subida del fichero
    //                 */
    //             if (empty($errores)) {
    //                 $datos_usuario["pass"] = encriptar($datos_usuario["pass"]);
    //                 $datos_usuario["id_user"] = $_SESSION['id_user'];
    //                 $datos_usuario["email"] = $_SESSION['email'];

    //                 $usuario = new Usuario();
    //                 $sesion = Sesion::getInstance();

    //                 $nivel = 1;
    //                 if ($usuario->updateUsuario($datos_usuario, $nivel)) {

    //                     $mensaje = "Usuario modificado correctamente";

    //                     $_SESSION["id_user"] = $datos_usuario["id_user"];
    //                     $_SESSION["email"] = $datos_usuario["email"];
    //                     $_SESSION["pass"] = $datos_usuario["pass"];
    //                     $_SESSION["nombre"] = $datos_usuario["nombre"];
    //                     $_SESSION["f_nacimiento"] = $datos_usuario["f_nacimiento"];
    //                     $_SESSION["foto_perfil"] = $datos_usuario["foto_perfil"];
    //                     $_SESSION["idiomas"] = $datos_usuario["idiomas"];
    //                     $_SESSION["descripcion"] = $datos_usuario["descripcion"];
    //                     $_SESSION["nivel"] = $nivel;
    //                     $_SESSION["ulitma_actividad"] = time();
    //                     $_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];

    //                     header("Location:index.php?ctl=perfil_usuario&mensaje=$mensaje");
    //                 }
    //             }
    //         }
    //     }
    //     require self::$ruta_layout;
    // }
}
