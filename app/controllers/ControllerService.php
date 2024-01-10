
<?php

class ControllerService extends Controller
{

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
