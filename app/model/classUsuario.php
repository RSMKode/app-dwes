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
        $usuario = $result->fetch(PDO::FETCH_ASSOC);
        if ($usuario) $usuario["idiomas"] = $this->getUsuarioIdiomas($usuario["id_user"]);

        return ($usuario) ? $usuario : false;
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
            $this->addUsuarioIdiomas($id_user, $datos_usuario["idiomas"]);

            $this->conexion->commit();

            return $id_user;
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

            $this->deleteUsuarioIdiomas($datos_usuario["id_user"]);
            $this->addUsuarioIdiomas($datos_usuario["id_user"], $datos_usuario["idiomas"]);

            return $this->conexion->commit();
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            return false;
        }
    }

    public function getUsuarioIdiomas($id_usuario)
    {
        $consulta = "SELECT * FROM `user-idioma` JOIN idioma ON `user-idioma`.id_idioma = idioma.id_idioma WHERE `user-idioma`.id_user = :id_usuario";
        /*$consulta = "SELECT * FROM usuario JOIN `user-idioma` ON usuario.id_user = `user-idioma`.id_user WHERE usuario.email = :email";
*/
        $result = $this->conexion->prepare($consulta);

        $result->bindParam(':id_usuario', $id_usuario);

        $result->execute();
        $resultado = $result->fetchAll(PDO::FETCH_ASSOC);
        $idiomas = [];
        foreach ($resultado as $idioma) {
            $idiomas[] = ["id_idioma" => $idioma["id_idioma"], "idioma" => $idioma["idioma"]];
        }

        return $idiomas;
    }

    public function addUsuarioIdiomas($id_usuario, $ids_idiomas)
    {
        try {
            foreach ($ids_idiomas as $id_idioma) {
                $consulta = "INSERT INTO `user-idioma` (id_user, id_idioma) 
                VALUES (:id_usuario, :id_idioma)";

                $result = $this->conexion->prepare($consulta);

                $result->bindParam(':id_usuario', $id_usuario);
                $result->bindParam(':id_idioma', $id_idioma);

                $result->execute();
            }
            return true;
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "src/logError.txt");
            return false;
        }
    }
    public function deleteUsuarioIdiomas($id_usuario)
    {
        try {

            $consulta = "DELETE FROM `user-idioma` WHERE id_user = :id_usuario";
            $result = $this->conexion->prepare($consulta);

            $result->bindParam(':id_usuario', $id_usuario);

            $result->execute();

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage() . microtime() . PHP_EOL, 3, "src/logError.txt");

            return false;
        }
    }
}
