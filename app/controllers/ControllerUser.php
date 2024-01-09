
<?php

class ControllerUser
{
    private static $ruta_layout = __DIR__ . '/../../web/templates/layout.php';

    public function inicio_sesion()
    {
        if ($_SESSION['nivel'] > 0) {
            header('Location: index.php?ctl=perfil_usuario');
        }

        $params = [
            'titulo' => "APP DWES",
            'vista' => 'index',
            'mensaje' => 'Bienvenido al repositorio de alimentos'
        ];

        require self::$ruta_layout;
    }
}
