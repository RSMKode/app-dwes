<?php
require_once('classModelo.php');

class Usuario_Idioma extends Modelo
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

    public function getIdiomaUsuario($id_usuario)
    {
        $consulta = "SELECT * FROM user-idioma WHERE id_user = :id_usuario";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_usuario', $id_usuario);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado[0];
    }


    public function addIdiomaUsuario($id_usuario, $id_idioma)
    {

        $consulta = "INSERT INTO user_idioma (id_user, id_idioma) 
                        values (:id_usuario, :id_idioma)";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_usuario', $id_usuario);
        $result->bindParam(':id_idioma', $id_idioma);


        return $result->execute();
    }
}
