<?php
require_once __DIR__.'/Conexion.php';

class CabVentaDatos {
    public function listarCabVentas() {
        $conexion = new Conexion();

        $conexion->query = "SELECT cv.IdCabVenta, cv.FechaVenta, cv.IdCliente, c.NombreCliente,
                            cv.IdVendedor, u.NombreCompleto AS NombreVendedor, cv.EstadoCabVenta
                            FROM tbl_cab_ventas cv
                            LEFT JOIN tbl_clientes c ON cv.IdCliente = c.IdCliente
                            LEFT JOIN tbl_usuarios u ON cv.IdVendedor = u.IdUsuario
                            WHERE cv.EstadoCabVenta = 'Activo'
                            ORDER BY cv.IdCabVenta DESC";

        return $conexion->get_records();
    }

    private function valorNulo($valor) {
        return trim($valor) === '' ? null : $valor;
    }

    public function insertarCabVenta($cabVenta) {
        $conexion = new Conexion();

        $conexion->query = "INSERT INTO tbl_cab_ventas (FechaVenta, IdCliente, IdVendedor, EstadoCabVenta)
                            VALUES (:fechaVenta, :idCliente, :idVendedor, :estado)";

        return $conexion->execute_query([
            ':fechaVenta' => $cabVenta['FechaVenta'],
            ':idCliente' => $cabVenta['IdCliente'],
            ':idVendedor' => $cabVenta['IdVendedor'],
            ':estado' => 'Activo'
        ]);
    }

    public function obtenerCabVentaPorId($idCabVenta) {
        $conexion = new Conexion();

        $conexion->query = "SELECT cv.IdCabVenta, cv.FechaVenta, cv.IdCliente, c.NombreCliente,
                            cv.IdVendedor, u.NombreCompleto AS NombreVendedor, cv.EstadoCabVenta
                            FROM tbl_cab_ventas cv
                            LEFT JOIN tbl_clientes c ON cv.IdCliente = c.IdCliente
                            LEFT JOIN tbl_usuarios u ON cv.IdVendedor = u.IdUsuario
                            WHERE cv.IdCabVenta = :idCabVenta";

        return $conexion->get_record([':idCabVenta' => $idCabVenta]);
    }

    public function actualizarCabVenta($cabVenta) {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_cab_ventas
                            SET FechaVenta = :fechaVenta,
                                IdCliente = :idCliente,
                                IdVendedor = :idVendedor
                            WHERE IdCabVenta = :idCabVenta";

        return $conexion->execute_query([
            ':fechaVenta' => $cabVenta['FechaVenta'],
            ':idCliente' => $cabVenta['IdCliente'],
            ':idVendedor' => $cabVenta['IdVendedor'],
            ':idCabVenta' => $cabVenta['IdCabVenta']
        ]);
    }

    public function eliminarCabVenta($idCabVenta) {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_cab_ventas SET EstadoCabVenta = 'Eliminado' WHERE IdCabVenta = :idCabVenta";

        return $conexion->execute_query([':idCabVenta' => $idCabVenta]);
    }
}
