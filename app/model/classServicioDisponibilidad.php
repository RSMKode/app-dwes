<?php
require_once('classModelo.php');

class ServicioDisponibilidad extends Modelo
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

    public function getServicioDisponibilidades($id_servicio)
    {
        $consulta = "SELECT * FROM disp_servicio WHERE id_servicio = :id_servicio";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_servicio', $id_servicio);

        $result->execute();
        $resultados = $result->fetchAll(PDO::FETCH_ASSOC);

        $disponibilidades = [];

        foreach ($resultados as $resultado) {
            $disponibilidades[] = $resultado['id_disponibilidad'];
        }

        return $disponibilidades;
    }

    public function addServicioDisponibilidades($id_servicio, $ids_disponibilidades)
    {
        try {
            foreach ($ids_disponibilidades as $id_disponibilidad) {
                $consulta = "INSERT INTO disp_servicio (id_servicio, id_disponibilidad) 
                        values (:id_servicio, :id_disponibilidad)";
                $result = $this->conexion->prepare($consulta);

                $result->bindParam(':id_servicio', $id_servicio);
                $result->bindParam(':id_disponibilidad', $id_disponibilidad);

                $result->execute();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function deleteServicioDisponibilidades($id_servicio)
    {
        try {

            $consulta = "DELETE FROM disp_servicios WHERE id_user = :id_servicio";
            $result = $this->conexion->prepare($consulta);

            $result->bindParam(':id_servicio', $id_servicio);

            $result->execute();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
