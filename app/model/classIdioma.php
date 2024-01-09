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

    public function getIdiomasIds()
    {
        $consulta = "SELECT id_idioma FROM idioma";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);

        $array_ids = [];

        foreach ($resultado as $elemento) {
            array_push($array_ids, $elemento["id_idioma"]);
        }
        return $array_ids;
    }
    public function getIdiomas()
    {
        $consulta = "SELECT * FROM idioma";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function getIdioma(array $ids_idiomas)
    {
        $string_idiomas = implode(",", $ids_idiomas);
        $consulta = "SELECT * FROM idioma WHERE id_idioma IN (:string_idiomas)";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':string_idiomas', $string_idiomas);

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
