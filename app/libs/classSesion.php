<?php

class Sesion
{
    protected $nombre_sesion = 'PHPSESSID';
    protected $tiempo_inactividad = 3600; // 1 hora
    protected static $instancia;

    public function __construct(int|bool $tiempo_inactividad = false, string|bool $nombre_sesion = false)
    {
        if ($tiempo_inactividad) {
            $this->tiempo_inactividad = $tiempo_inactividad;
        }

        if ($nombre_sesion) {
            $this->nombre_sesion = $nombre_sesion;
        }

        $this->iniciarSesion();
    }

    public static function getInstance(): Sesion
    {
        // Si la instancia no existe, la creamos
        if (!self::$instancia) {
            self::$instancia = new Sesion();
        }

        // Devolvemos la instancia
        return self::$instancia;
    }


    private function iniciarSesion(): void
    {
        session_start();

        if (isset($_SESSION['nivel'])) {
            if ($_SESSION['nivel'] > 0) {
                // $this->comprobarInactividad();
                // $this->comprobarIP();
            }
        } else {
            $_SESSION['nivel'] = 0;
        }
    }

    public function cerrarSesion(): void
    {
        // Eliminar todas las variables de sesión
        unset($_SESSION);

        // Eliminar la cookie de sesión
        session_destroy();
    }

    public function login(string $correo, string $pass, array &$errores): bool
    {
        // Regenerar identificador de sesión
        session_regenerate_id();

        $usuario = new Usuario();
        if ($datos_usuario = $usuario->verificarUsuario($correo, $pass)) {
            // Almacenar información relevante

            $_SESSION["id_user"] = $datos_usuario["id_user"];
            $_SESSION["email"] = $datos_usuario["email"];
            $_SESSION["pass"] = $datos_usuario["pass"];
            $_SESSION["nombre"] = $datos_usuario["nombre"];
            $_SESSION["f_nacimiento"] = $datos_usuario["f_nacimiento"];
            $_SESSION["foto_perfil"] = $datos_usuario["foto_perfil"];
            // $_SESSION["idioma"] = $datos_usuario["idioma"];
            $_SESSION["descripcion"] = $datos_usuario["descripcion"];
            $_SESSION["nivel"] = $datos_usuario["nivel"];
            $_SESSION["ulitma_actividad"] = time();
            $_SESSION["ip"] = $_SERVER['REMOTE_ADDR'];
            return true;
        } else {
            $errores['login'] = "Usuario o contraseña incorrectos";
            return false;
        }
    }

    public function comprobarInactividad(): bool
    {
        // Comprobar tiempo de inactividad
        if (time() - $_SESSION['ultima_actividad'] > $this->tiempo_inactividad) {
            $this->cerrarSesion();
            return false;
        }

        // Renovar tiempo de vida de la sesión
        $_SESSION['ultima_actividad'] = time();

        return true;
    }

    public function comprobarIP(): void
    {
        if ($_SESSION['user_ip'] !== $_SERVER['REMOTE_ADDR']) {
            $this->cerrarSesion();
        }
    }

    public function setValorSesion(string $clave, string $valor): void
    {
        $_SESSION[$clave] = $valor;
    }

    public function getValorSesion(string $clave): string
    {
        return $_SESSION[$clave];
    }

    public function deleteValorSesion(string $clave): string
    {
        unset($_SESSION[$clave]);
        return true;
    }
}
