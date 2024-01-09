<?php
require_once('classModelo.php');

class Usuario extends Modelo
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

    public function getUsuariosIds()
    {
        $consulta = "SELECT id_user FROM usuario";
        $result = $this->conexion->prepare($consulta);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
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

    public function verificarUsuario($email, $pass)
    {
        $consulta = "SELECT * FROM usuario WHERE email = :email";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':email', $email);
        $result->execute();

        $array_datos = $result->fetchAll(PDO::FETCH_ASSOC);
        $datos_usuario = (count($array_datos) == 1) ? $array_datos[0] : false;

        if ($datos_usuario) {
            if (comprobarhash($pass, $datos_usuario['pass'])) return $datos_usuario;
            //Almacenamos en sesión todo lo necesario. Si tenemos ruta imagen perfil y nivel usuario
        }

        return false;
    }

    public function addUsuario($datos_usuario)
    {
        $datos_usuario["nivel"] = 1;
        $datos_usuario["activo"] = 0;

        $consulta = "INSERT INTO usuario (nombre, email, pass, f_nacimiento, foto_perfil, descripcion, nivel, activo) 
                        values (:nombre, :email, :pass, :f_nacimiento, :foto_perfil, :descripcion, :nivel, :activo)";
        $result = $this->conexion->prepare($consulta);

        return $result->execute($datos_usuario);
    }
}
