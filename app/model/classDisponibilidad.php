<?php
require_once('classModelo.php');

class Disponibilidad extends Modelo
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

    public function getDisponibilidadesIds()
    {
        $consulta = "SELECT * FROM disponibilidad";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);

        $array_disponibilidades = [];

        foreach ($resultado as $elemento) {
            $array_disponibilidades[$elemento['id_disponibilidad']] = $elemento["disponibilidad"];
        }
        return $array_disponibilidades;
    }
    public function getDisponibilidades()
    {
        $consulta = "SELECT * FROM disponibilidad";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function getDisponibilidadesAdmin(array $ids_disponibilidades)
    {
        $string_disponibilidades = implode(",", $ids_disponibilidades);
        $consulta = "SELECT * FROM disponibilidad WHERE id_disponibilidad IN (:string_disponibilidades)";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':string_idiomas', $string_disponibilidades);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado[0];
    }

    public function addDisponibilidad($datos_usuario)
    {
        // $datos_usuario["nivel"] = 1;
        // $datos_usuario["activo"] = 0;

        // $consulta = "INSERT INTO usuario (nombre, email, pass, f_nacimiento, foto_perfil, descripcion, nivel, activo) 
        //                 values (:nombre, :email, :pass, :f_nacimiento, :foto_perfil, :descripcion, :nivel, :activo)";
        // $result = $this->conexion->prepare($consulta);

        // return $result->execute($datos_usuario);
    }
}
