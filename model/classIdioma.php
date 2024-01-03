<?php
require_once('classModelo.php');

class Idioma extends Modelo
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

    public function getUsuario($id_usuario)
    {
        $consulta = "SELECT * FROM usuario WHERE id_user = :id_usuario";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_usuario', $id_usuario);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado[0];
    }

    public function addIdioma($datos_usuario)
    {
        $datos_usuario["nivel"] = 1;
        $datos_usuario["activo"] = 0;

        $consulta = "INSERT INTO usuario (nombre, email, pass, f_nacimiento, foto_perfil, descripcion, nivel, activo) 
                        values (:nombre, :email, :pass, :f_nacimiento, :foto_perfil, :descripcion, :nivel, :activo)";
        $result = $this->conexion->prepare($consulta);

        return $result->execute($datos_usuario);
    }
}
