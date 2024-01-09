<?php

class Controller
{

    public function inicio()
    {
        $params = array(
            'visual' => ["vista" => "inicio"],
            'mensaje' => 'Bienvenido al repositorio de alimentos',
            'fecha' => date('d-m-y')
        );

        require __DIR__ . '/../../web/templates/inicio.php';
    }

    public function error()
    {
        require __DIR__ . '/../../web/templates/error.php';
    }

    public function listar()
    {
        try {
            $m = new Alimentos();
            $params = array(
                'alimentos' => $m->dameAlimentos()
            );

            // Recogemos los dos tipos de excepciones que se pueden producir
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        $menu = 'menu2.php';
        require __DIR__ . '/../../web/templates/mostrarAlimentos.php';
    }

    public function insertar()
    {
        try {
            $params = array(
                'nombre' => '',
                'energia' => '',
                'proteina' => '',
                'hc' => '',
                'fibra' => '',
                'grasa' => ''
            );

            if (isset($_POST['insertar'])) {
                $nombre = recoge('nombre');
                $energia = recoge('energia');
                $proteina = recoge('proteina');
                $hc = recoge('hc');
                $fibra = recoge('fibra');
                $grasa = recoge('grasa');
                // comprobar campos formulario. Aqui va la validación con las funciones de bGeneral o la clase Validacion
                if (validarDatos($nombre, $energia, $proteina, $hc, $fibra, $grasa)) {

                    // Si no ha habido problema creo modelo y hago inserción
                    $m = new Alimentos();
                    if ($m->insertarAlimento($nombre, $energia, $proteina, $hc, $fibra, $grasa)) {
                        header('Location: index.php?ctl=listar');
                    } else {
                        $params = array(
                            'nombre' => $nombre,
                            'energia' => $energia,
                            'proteina' => $proteina,
                            'hc' => $hc,
                            'fibra' => $fibra,
                            'grasa' => $grasa
                        );
                        $params['mensaje'] = 'No se ha podido insertar el alimento. Revisa el formulario';
                    }
                } else {
                    $params = array(
                        'nombre' => $nombre,
                        'energia' => $energia,
                        'proteina' => $proteina,
                        'hc' => $hc,
                        'fibra' => $fibra,
                        'grasa' => $grasa
                    );
                    $params['mensaje'] = 'Hay datos que no son correctos. Revisa el formulario';
                }
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/formInsertar.php';
    }

    public function buscarPorNombre()
    {
        try {
            $params = array(
                'nombre' => '',
                'resultado' => array()
            );
            $m = new Alimentos();
            if (isset($_POST['buscar'])) {
                $nombre = recoge("nombre");
                $params['nombre'] = $nombre;
                $params['resultado'] = $m->buscarAlimentosPorNombre($nombre);
            }
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }
        require __DIR__ . '/../../web/templates/buscarPorNombre.php';
    }

    public function ver()
    {
        try {
            if (!isset($_GET['id'])) {
                throw new Exception('Página no encontrada');
            }
            $id = recoge('id');
            $m = new Alimentos();
            $params['alimentos'] = $m->dameAlimento($id);
            if (!$params['alimentos'])
                $params['mensaje'] = "No hay detalles que mostar";
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logExceptio.txt");
            header('Location: index.php?ctl=error');
        } catch (Error $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "logError.txt");
            header('Location: index.php?ctl=error');
        }

        require __DIR__ . '/../../web/templates/verAlimento.php';
    }
}
