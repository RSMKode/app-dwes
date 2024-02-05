<?php
require_once('classModelo.php');

class Token extends Modelo
{
    /**
     * En esta clase crearemos las consultas relacionadas con la tabla usuarios
     */
    private $conexion;
    public function __construct()
    {
        /*Los datos de la conexión los tomamos de config*/
        $this->conexion = parent::GetInstance();
    }

    public function getToken($id_user)
    {
        $consulta = "SELECT * FROM tokens WHERE id_user = :id_user";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_user', $id_user);

        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function getTokenUser($token)
    {

        $consulta = "SELECT * FROM tokens WHERE token = :token";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':token', $token);

        $result->execute();

        $datos_token = $result->fetch(PDO::FETCH_ASSOC);

        if ($datos_token && time() > $datos_token['validez']) {
            $this->deleteToken($token);
            return false;
        }

        if ($datos_token) return $datos_token['id_user'];
    }


    public function addToken($token, $validez, $id_user)
    {
        if ($token_prev = $this->getToken($id_user)) {
            $this->deleteToken($token_prev['id_user']);
        }

        $consulta = "INSERT INTO tokens (token, validez, id_user) 
                        values (:token, :validez, :id_user)";

        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':token', $token);
        $result->bindParam(':validez', $validez);
        $result->bindParam(':id_user', $id_user);

        return $result->execute();
    }


    public function deleteToken($id_user)
    {
        $consulta = "DELETE FROM tokens WHERE id_user = :id_user";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_user', $id_user);

        return $result->execute();
    }
}
