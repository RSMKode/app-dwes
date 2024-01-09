
<?php

class ControllerService
{
    private static $ruta_layout = __DIR__ . '/../../web/templates/layout.php';

    public function index()
    {
        $params = [
            'titulo' => "APP DWES",
            'vista' => 'index',
            'mensaje' => 'Bienvenido al repositorio de alimentos'
        ];

        require self::$ruta_layout;
    }

    public function error()
    {
        require self::$ruta_layout;
    }
}
