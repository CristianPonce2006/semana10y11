<?php
require_once __DIR__.'/Conexion.php';
class MarcaDatos{

    public function listarMarcas(){
        $conexion = new Conexion();

        $conexion->query = "SELECT IdMarca, NombreMarca, EstadoMarca
                            FROM tbl_marcas
                            WHERE EstadoMarca = 'Disponible'
                            ORDER BY IdMarca DESC";

        return $conexion->get_records();
    }

    public function insertarMarca($marca)
    {
        $conexion = new Conexion();

        $conexion->query = "INSERT INTO tbl_marcas (NombreMarca)
                            VALUES (:nombre)";

        return $conexion->execute_query([
            ':nombre'   => trim($marca['NombreMarca'])
        ]);
    }

    public function actualizarMarca($marca)
    {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_marcas SET NombreMarca = :nombre
                            WHERE IdMarca = :idMarca";

        return $conexion->execute_query([
            ':nombre'    => trim($marca['NombreMarca']),
            ':idMarca' => $marca['IdMarca']
        ]);
    }

    public function obtenerMarcaPorId($idMarca)
    {
        $conexion = new Conexion();

        $conexion->query = "SELECT IdMarca, NombreMarca, EstadoMarca
                            FROM tbl_marcas
                            WHERE IdMarca = :idMarca";

        return $conexion->get_record([':idMarca' => $idMarca]);
    }

    public function eliminarMarca($idMarca)
    {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_marcas SET EstadoMarca = 'Eliminado' WHERE IdMarca = :idMarca";

        return $conexion->execute_query([':idMarca' => $idMarca]);
    }
}