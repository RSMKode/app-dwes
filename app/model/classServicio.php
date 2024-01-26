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
        $consulta = "SELECT id_serivicios FROM servicios";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function getServiciosUser($id_user)
    {
        require_once('../app/model/classServicioDisponibilidad.php');

        $consulta = "SELECT * FROM servicios WHERE id_user = :id_user";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_user', $id_user);

        $result->execute();

        $servicios = $result->fetchAll(PDO::FETCH_ASSOC);

        $servicio_disponibilidad = new ServicioDisponibilidad();

        $disponibilidad = new Disponibilidad();
        $disponibilidades_ids = $disponibilidad->getDisponibilidades();

        // foreach ($servicios as &$servicio) {
        //             $disponibilidades = [];
        //             $disponibilidadesServicio = $servicio_disponibilidad->getServicioDisponibilidades($servicio['id_servicio']);
        //             print_r($disponibilidadesServicio);
        //             foreach ($disponibilidadesServicio as $disponibilidad) {
        //                 print_r($disponibilidad);

        //                 $disponibilidades[] = $disponibilidades_ids[$disponibilidad];
        //             }
        //             print_r($disponibilidades);
        //             $servicio["disponibilidades"] = $disponibilidades;
        //         }

        foreach ($servicios as &$servicio) {
            $disponibilidades = $servicio_disponibilidad->getServicioDisponibilidades($servicio['id_servicio']);
            $servicio["disponibilidades"] = $disponibilidades;
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
            $servicio_disponibilidad = new ServicioDisponibilidad();
            $servicio_disponibilidad->addServicioDisponibilidades($id_servicio, $datos_servicio["disponibilidades"]);

            return $this->conexion->commit();
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
    // public function updateUsuario($datos_usuario, $nivel_usuario)
    // {
    //     try {
    //         $this->conexion->beginTransaction();

    //         $datos_usuario["nivel"] = $nivel_usuario;

    //         $consulta = "UPDATE usuario SET nombre = :nombre, pass = :pass, f_nacimiento = :f_nacimiento, foto_perfil = :foto_perfil, descripción = :descripción, nivel = :nivel, activo = :activo WHERE email = :email";

    //         $result = $this->conexion->prepare($consulta);

    //         $result->bindParam(':nombre', $datos_usuario["nombre"]);
    //         $result->bindParam(':email', $datos_usuario["email"]);
    //         $result->bindParam(':pass', $datos_usuario["pass"]);
    //         $result->bindParam(':f_nacimiento', $datos_usuario["f_nacimiento"]);
    //         $result->bindParam(':foto_perfil', $datos_usuario["foto_perfil"]);
    //         $result->bindParam(':descripción', $datos_usuario["descripción"]);
    //         $result->bindParam(':nivel', $datos_usuario["nivel"]);
    //         $result->bindParam(':activo', $datos_usuario["activo"]);

    //         $result->execute();

    //         $servicio_disponibilidad = new ServicioDisponibilidad();
    //         $servicio_disponibilidad->deleteServicioDisponibilidades($datos_usuario["id_servicio"]);
    //         $servicio_disponibilidad->addServicioDisponibilidades($datos_usuario["id_servicio"], $datos_servicio["disponibilidades"]);

    //         return $this->conexion->commit();
    //     } catch (PDOException $e) {
    //         $this->conexion->rollBack();
    //         return false;
    //     }
    // }
}
