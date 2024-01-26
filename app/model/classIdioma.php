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
        $consulta = "SELECT * FROM idioma";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);

        $array_idiomas = [];

        foreach ($resultado as $elemento) {
            $array_idiomas[$elemento['id_idioma']] = $elemento["idioma"];
        }
        return $array_idiomas;
    }
    public function getIdiomas()
    {
        $consulta = "SELECT * FROM idioma";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function getIdiomasAdmin(array $ids_idiomas)
    {
        $string_idiomas = implode(",", $ids_idiomas);
        $consulta = "SELECT * FROM idioma WHERE id_idioma IN (:string_idiomas)";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':string_idiomas', $string_idiomas);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado[0];
    }

    public function addIdioma($idioma)
    {
        $consulta = "INSERT INTO idioma (idioma) 
                        values (:idioma)";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':idioma', $idioma);

        return $result->execute();
    }

    public function deleteIdioma($id_idioma)
    {
        $consulta = "DELETE FROM idioma WHERE id_idioma = :id_idioma";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_idioma', $id_idioma);

        return $result->execute();
    }
}
