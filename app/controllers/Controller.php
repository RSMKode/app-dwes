
<?php

class Controller
{
    protected static $ruta_layout = __DIR__ . '/../../web/templates/layout.php';

    public function indice()
    {
        $servicio = new Servicio();
        $servicios = $servicio->getServicios();

        $params = [
            'titulo' => "APP DWES",
            'vista' => 'indice',
            'mensaje' => 'Bienvenido al repositorio de alimentos',
            'servicios' => $servicios
        ];

        require self::$ruta_layout;
    }

    public function error()
    {
        $params = [
            'titulo' => 'Error 404',
            'vista' => 'error',
            'error' => 'No existe la ruta <span class="accent">' . $_GET['error'] . '</span>'
        ];
        require self::$ruta_layout;
    }
}
