<?php
require_once __DIR__.'/Conexion.php';
class CategoriaDatos{

    public function listarCategorias(){
        $conexion = new Conexion();

        $conexion->query = "SELECT IdCategoria, NombreCategoria, EstadoCategoria
                            FROM tbl_categorias
                            WHERE EstadoCategoria = 'Activa'
                            ORDER BY IdCategoria DESC";

        return $conexion->get_records();
    }

    private function valorNulo($valor){
        return trim($valor) ===''? null: $valor;
    }

    public function insertarCategoria($categoria)
    {
        $conexion = new Conexion();

        $conexion->query = "INSERT INTO tbl_categorias (NombreCategoria)
                            VALUES (:nombre)";

        return $conexion->execute_query([
            ':nombre'   => $this->valorNulo($categoria['NombreCategoria'])
        ]);
    }

    public function actualizarCategoria($categoria)
    {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_categorias SET NombreCategoria = :nombre
                            WHERE IdCategoria = :idCategoria";

        return $conexion->execute_query([
            ':nombre'    => $this->valorNulo($categoria['NombreCategoria']),
            ':idCategoria' => $categoria['IdCategoria']
        ]);
    }

    public function obtenerCategoriaPorId($idCategoria)
    {
        $conexion = new Conexion();

        $conexion->query = "SELECT IdCategoria, NombreCategoria, EstadoCategoria
                            FROM tbl_categorias
                            WHERE IdCategoria = :idCategoria";

        return $conexion->get_record([':idCategoria' => $idCategoria]);
    }

    public function eliminarCategoria($idCategoria)
    {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_categorias SET EstadoCategoria = 'Eliminada' WHERE IdCategoria = :idCategoria";

        return $conexion->execute_query([':idCategoria' => $idCategoria]);
    }

}