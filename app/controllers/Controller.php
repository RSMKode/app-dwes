
<?php


class Controller extends Sesion
{
    protected static $ruta_layout = __DIR__ . '/../../web/templates/layout.php';

    public function indice()
    {
        $params = [
            'titulo' => "APP DWES",
            'vista' => 'indice',
            'mensaje' => 'Bienvenido al repositorio de alimentos'
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
