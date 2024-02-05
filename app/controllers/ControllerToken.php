
<?php

class ControllerToken extends Controller
{
    public function enviar_token()
    {
        $params = [
            'titulo' => 'Inicio de sesión',
            'vista' => 'inicio_sesion',
        ];

        $errores = [];

        $email = recoge('email');
        cTexto($email, 'token', $errores, "email");

        if (empty($errores)) {
            $usuario = new Usuario();
            if ($datos_usuario = $usuario->getUsuario($email)) {
                $token = new Token;
                $user_token = uniqid();
                $validez = 60 * 60 * 24 + time();
                if ($token->addToken($user_token, $validez, $datos_usuario["id_user"])) {
                    //mandar email
                    sendEmailToken($email, $user_token);
                    $params['mensaje'] = "Token reenviado corretamente";
                }
                unset($datos_usuario);
            }
        }

        require self::$ruta_layout;
    }

    public function confirmar_token()
    {
        $params = [
            'titulo' => 'Inicio de sesión',
            'vista' => 'inicio_sesion',
        ];

        $errores = [];

        $tokenid = recoge('token');
        cTexto($tokenid, 'token', $errores, "token");

        if (empty($errores)) {
            $token = new Token();
            if ($id_user = $token->getTokenUser($tokenid)) {
                $usuario = new Usuario();
                if ($usuario->activarUsuario($id_user)) {
                    $token->deleteToken($id_user);
                    $params['mensaje'] = "Usuario activado corretamente";
                }
            } else {
                $params['mensaje'] = "No se ha podido activar el usuario. Vuelve a intentar iniciar sesión.";
            }
        }

        require self::$ruta_layout;
    }
}
