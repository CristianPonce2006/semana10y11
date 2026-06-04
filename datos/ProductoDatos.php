<?php

require_once __DIR__.'/Conexion.php';

class ProductoDatos {
    public function listarProductos() {
        $conexion = new Conexion();

        

    $conexion->query = "SELECT tbl_productos.IdProducto, tbl_productos.NombreProducto, tbl_productos.Modelo,
                               tbl_productos.IdCategoria, tbl_categorias.NombreCategoria, tbl_productos.IdMarca,
                               tbl_marcas.NombreMarca, tbl_productos.PrecioVenta, tbl_productos.Caracteristicas,
                               tbl_productos.Existencias, tbl_productos.Imagen, tbl_productos.EstadoProducto
                        FROM tbl_productos
                        INNER JOIN tbl_categorias ON tbl_productos.IdCategoria = tbl_categorias.IdCategoria
                        INNER JOIN tbl_marcas ON tbl_productos.IdMarca = tbl_marcas.IdMarca
                        WHERE tbl_productos.EstadoProducto = 'Activo'
                        ORDER BY tbl_productos.IdProducto DESC";

        return $conexion->get_records();
    }
    private function valorNulo($valor) {
        return trim($valor) === '' ? null : $valor;
    }

    public function insertarProducto($producto) {
        $conexion = new Conexion();

        $conexion->query = "INSERT INTO tbl_productos (NombreProducto, Modelo, IdCategoria, IdMarca, PrecioVenta, Caracteristicas, Existencias, Imagen)
                            VALUES (:nombreProducto, :modelo, :idCategoria, :idMarca, :precioVenta, :caracteristicas, :existencias, :imagen)";

        return $conexion->execute_query([
            ':nombreProducto' => $this->valorNulo($producto['NombreProducto']),
            ':modelo'         => $this->valorNulo($producto['Modelo']),
            ':idCategoria'    => $this->valorNulo($producto['IdCategoria']),
            ':idMarca'        => $this->valorNulo($producto['IdMarca']),
            ':precioVenta'    => $this->valorNulo($producto['PrecioVenta']),
            ':caracteristicas' => $this->valorNulo($producto['Caracteristicas']),
            ':existencias'    => $this->valorNulo($producto['Existencias']),
            ':imagen'         => $this->valorNulo($producto['Imagen'])
        ]);
    }

    public function obtenerProductoPorId($idProducto) {
        $conexion = new Conexion();

         $conexion->query = "SELECT
        tbl_productos.IdProducto, tbl_productos.NombreProducto, tbl_productos.Modelo,
        tbl_productos.IdCategoria, tbl_categorias.NombreCategoria, tbl_productos.IdMarca,
        tbl_marcas.NombreMarca, tbl_productos.PrecioVenta, tbl_productos.Caracteristicas,
        tbl_productos.Existencias, tbl_productos.Imagen, tbl_productos.EstadoProducto
        FROM tbl_productos
        INNER JOIN tbl_categorias ON tbl_productos.IdCategoria = tbl_categorias.IdCategoria
        INNER JOIN tbl_marcas ON tbl_productos.IdMarca = tbl_marcas.IdMarca
        WHERE tbl_productos.IdProducto = :idProducto
        AND tbl_productos.EstadoProducto = 'Activo'";

        return $conexion->get_record([':idProducto' => $idProducto]);
    }

    public function actualizarProducto($producto){
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_productos
            SET NombreProducto = :nombreProducto, Modelo = :modelo,
            IdCategoria = :idCategoria, IdMarca = :idMarca,
            PrecioVenta = :precioVenta, Caracteristicas = :caracteristicas,
            Existencias = :existencias, Imagen = :imagen
            WHERE IdProducto = :idProducto";

        return $conexion->execute_query([
            'nombreProducto' => $producto['NombreProducto'],
            'modelo' => $this->valorNulo($producto['Modelo']),
            'idCategoria' => $producto['IdCategoria'],
            'idMarca' => $producto['IdMarca'],
            'precioVenta' => $producto['PrecioVenta'],
            'caracteristicas' => $this->valorNulo($producto['Caracteristicas']),
            'existencias' => $producto['Existencias'],
            'imagen' => $this->valorNulo($producto['Imagen']),
            'idProducto' => $producto['IdProducto']
        ]);
    }

    


}
