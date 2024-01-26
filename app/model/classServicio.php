<?php
require_once('classModelo.php');

class Servicio extends Modelo
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

    public function getServicios()
    {
        $consulta = "SELECT * FROM servicios";
        $result = $this->conexion->prepare($consulta);

        $result->execute();

        $servicios = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($servicios as &$servicio) {
            $servicio["disponibilidades"] = $this->getServicioDisponibilidades($servicio["id_servicios"]);
        }

        return $servicios ? $servicios : false;
    }

    public function getServicio($id_servicio)
    {
        $consulta = "SELECT * FROM servicios WHERE id_servicios = :id_servicio";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_servicio', $id_servicio);

        $result->execute();

        $servicio = $result->fetch(PDO::FETCH_ASSOC);

        $servicio["disponibilidades"] = $this->getServicioDisponibilidades($servicio["id_servicios"]);

        return $servicio ? $servicio : false;
    }

    public function getServiciosUser($id_user)
    {
        $consulta = "SELECT * FROM servicios WHERE id_user = :id_user";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_user', $id_user);

        $result->execute();

        $servicios = $result->fetchAll(PDO::FETCH_ASSOC);
        foreach ($servicios as &$servicio) {
            $servicio["disponibilidades"] = $this->getServicioDisponibilidades($servicio["id_servicios"]);
        }

        return $servicios ? $servicios : false;
    }

    public function addServicio($datos_servicio)
    {
        try {
            $this->conexion->beginTransaction();

            $consulta = "INSERT INTO servicios (titulo, id_user, descripcion, precio, tipo, foto_servicio) 
                        values (:titulo, :id_user, :descripcion, :precio, :tipo, :foto_servicio)";

            $result = $this->conexion->prepare($consulta);

            $result->bindParam(':titulo', $datos_servicio["titulo"]);
            $result->bindParam(':id_user', $datos_servicio["id_user"]);
            $result->bindParam(':descripcion', $datos_servicio["descripcion"]);
            $result->bindParam(':precio', $datos_servicio["precio"]);
            $result->bindParam(':tipo', $datos_servicio["tipo"]);
            $result->bindParam(':foto_servicio', $datos_servicio["foto_servicio"]);


            $result->execute();

            $id_servicio = $this->conexion->lastInsertId();
            $this->addServicioDisponibilidades($id_servicio, $datos_servicio["disponibilidades"]);

            return $this->conexion->commit();
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
    public function getServicioDisponibilidades($id_servicio)
    {
        $consulta = "SELECT * FROM disp_servicio JOIN disponibilidad ON disp_servicio.id_disponibilidad = disponibilidad.id_disponibilidad WHERE disp_servicio.id_servicio = :id_servicio";

        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_servicio', $id_servicio);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        $disponibilidades = [];
        foreach ($resultado as $disponibilidad) {
            $disponibilidades[] = ["id_disponibilidad" => $disponibilidad["id_disponibilidad"], "disponibilidad" => $disponibilidad["disponibilidad"]];
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
    public function updateServicio($datos_servicio)
    {
        // try {
        //     $this->conexion->beginTransaction();

        //     $datos_usuario["nivel"] = $nivel_usuario;

        //     $consulta = "UPDATE usuario SET nombre = :nombre, pass = :pass, f_nacimiento = :f_nacimiento, foto_perfil = :foto_perfil, descripción = :descripción, nivel = :nivel, activo = :activo WHERE email = :email";

        //     $result = $this->conexion->prepare($consulta);

        //     $result->bindParam(':nombre', $datos_usuario["nombre"]);
        //     $result->bindParam(':email', $datos_usuario["email"]);
        //     $result->bindParam(':pass', $datos_usuario["pass"]);
        //     $result->bindParam(':f_nacimiento', $datos_usuario["f_nacimiento"]);
        //     $result->bindParam(':foto_perfil', $datos_usuario["foto_perfil"]);
        //     $result->bindParam(':descripción', $datos_usuario["descripción"]);
        //     $result->bindParam(':nivel', $datos_usuario["nivel"]);
        //     $result->bindParam(':activo', $datos_usuario["activo"]);

        //     $result->execute();

        //     $servicio_disponibilidad = new ServicioDisponibilidad();
        //     $servicio_disponibilidad->deleteServicioDisponibilidades($datos_usuario["id_servicio"]);
        //     $servicio_disponibilidad->addServicioDisponibilidades($datos_usuario["id_servicio"], $datos_servicio["disponibilidades"]);

        //     return $this->conexion->commit();
        // } catch (PDOException $e) {
        //     $this->conexion->rollBack();
        //     return false;
        // }
    }
}
