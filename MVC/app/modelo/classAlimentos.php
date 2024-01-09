<?php

class Alimentos extends Modelo
{

    public function dameAlimentos()
    {
        $consulta = "select * from alimentos order by energia desc";
        $result = $this->conexion->query($consulta);
        return $result->fetchAll();
    }

    public function buscarAlimentosPorNombre($nombre)
    {
        $consulta = "select * from alimentos where nombre like :nombre order by energia desc";

        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':nombre', $nombre);
        $result->execute();

        return $result->fetchAll();
    }

    public function dameAlimento($id)
    {
        $consulta = "select * from alimentos where id=:id";

        $result = $this->conexion->prepare($consulta);
        $result->bindParam(':id', $id);
        $result->execute();
        return $result->fetch();
    }

    public function insertarAlimento($n, $e, $p, $hc, $f, $g)
    {
        $consulta = "insert into alimentos (nombre, energia, proteina, hidratocarbono, fibra, grasatotal) values (?, ?, ?, ?, ?, ?)";
        $result = $this->conexion->prepare($consulta);
        $result->bindParam(1, $n);
        $result->bindParam(2, $e);
        $result->bindParam(3, $p);
        $result->bindParam(4, $hc);
        $result->bindParam(5, $f);
        $result->bindParam(6, $g);
        $result->execute();

        return $result;
    }
}
