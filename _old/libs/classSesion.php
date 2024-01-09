<?php
class Sesion
{
    protected $nombre_sesion = 'PHPSESSID';
    protected $tiempo_inactividad = 3600; // 1 hora

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

    private function iniciarSesion(): void
    {
        session_name($this->nombre_sesion);
        session_start();

        if (isset($_SESSION['logueado'])) {
            $this->comprobarInactividad();
            $this->comprobarIP();
        }
    }

    public function cerrarSesion(): void
    {
        // Eliminar todas las variables de sesión
        unset($_SESSION);

        // Eliminar la cookie de sesión
        session_destroy();
    }

    public function login(string $user, int $nivelUsuario, string $pass, string $rutaImagen): bool
    {
        // Regenerar identificador de sesión
        session_regenerate_id();

        // Almacenar información relevante
        $_SESSION['logueado'] = true;
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        $_SESSION['nivel_usuario'] = $nivelUsuario;
        $_SESSION['imagen_perfil'] = $rutaImagen;
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['ultima_actividad'] = time();

        return true;
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
}
