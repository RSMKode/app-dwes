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

    public function getUsuario($email)
    {
        $consulta = "SELECT * FROM usuario WHERE email = :email";
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':email', $email);

        $result->execute();

        return ($resultado = $result->fetch(PDO::FETCH_ASSOC)) ? $resultado : false;
    }

    public function verificarUsuario($email, $pass)
    {
        $datos_usuario = $this->getUsuario($email);

        if ($datos_usuario) {
            if (comprobarhash($pass, $datos_usuario['pass'])) return $datos_usuario;
            //Almacenamos en sesión todo lo necesario. Si tenemos ruta imagen perfil y nivel usuario
        }

        return false;
    }

    public function addUsuario($datos_usuario, $nivel_usuario)
    {
        try {
            $this->conexion->beginTransaction();

            $datos_usuario["nivel"] = $nivel_usuario;
            $datos_usuario["activo"] = 0;

            $consulta = "INSERT INTO usuario (nombre, email, pass, f_nacimiento, foto_perfil, descripción, nivel, activo) 
                        values (:nombre, :email, :pass, :f_nacimiento, :foto_perfil, :descripcion, :nivel, :activo)";

            $result = $this->conexion->prepare($consulta);

            $result->bindParam(':nombre', $datos_usuario["nombre"]);
            $result->bindParam(':email', $datos_usuario["email"]);
            $result->bindParam(':pass', $datos_usuario["pass"]);
            $result->bindParam(':f_nacimiento', $datos_usuario["f_nacimiento"]);
            $result->bindParam(':foto_perfil', $datos_usuario["foto_perfil"]);
            $result->bindParam(':descripcion', $datos_usuario["descripcion"]);
            $result->bindParam(':nivel', $datos_usuario["nivel"]);
            $result->bindParam(':activo', $datos_usuario["activo"]);

            $result->execute();

            $id_user = $this->conexion->lastInsertId();
            $usuario_idioma = new UsuarioIdioma();
            $usuario_idioma->addUsuarioIdiomas($id_user, $datos_usuario["idiomas"]);

            return $this->conexion->commit();
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
    public function updateUsuario($datos_usuario, $nivel_usuario)
    {
        try {
            $this->conexion->beginTransaction();

            $datos_usuario["nivel"] = $nivel_usuario;

            $consulta = "UPDATE usuario SET nombre = :nombre, pass = :pass, f_nacimiento = :f_nacimiento, foto_perfil = :foto_perfil, descripción = :descripcion, nivel = :nivel, activo = :activo WHERE email = :email";

            $result = $this->conexion->prepare($consulta);

            $result->bindParam(':nombre', $datos_usuario["nombre"]);
            $result->bindParam(':email', $datos_usuario["email"]);
            $result->bindParam(':pass', $datos_usuario["pass"]);
            $result->bindParam(':f_nacimiento', $datos_usuario["f_nacimiento"]);
            $result->bindParam(':foto_perfil', $datos_usuario["foto_perfil"]);
            $result->bindParam(':descripcion', $datos_usuario["descripcion"]);
            $result->bindParam(':nivel', $datos_usuario["nivel"]);
            $result->bindParam(':activo', $datos_usuario["activo"]);

            $result->execute();

            $usuario_idioma = new UsuarioIdioma();
            $usuario_idioma->deleteUsuarioIdiomas($datos_usuario["id_user"]);
            $usuario_idioma->addUsuarioIdiomas($datos_usuario["id_user"], $datos_usuario["idiomas"]);

            return $this->conexion->commit();
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return false;
        }
    }
}
