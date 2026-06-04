<?php
require_once __DIR__.'/Conexion.php';

class DetVentaDatos {
    public function listarDetVentas() {
        $conexion = new Conexion();

        $conexion->query = "SELECT dv.IdDetVenta, dv.IdCabVenta, dv.IdProducto, p.NombreProducto,
                            dv.Cantidad, dv.PrecioUnitario, dv.EstadoDetVenta
                            FROM tbl_det_ventas dv
                            LEFT JOIN tbl_productos p ON dv.IdProducto = p.IdProducto
                            WHERE dv.EstadoDetVenta = 'Activo'
                            ORDER BY dv.IdDetVenta DESC";

        return $conexion->get_records();
    }

    private function valorNulo($valor) {
        return trim($valor) === '' ? null : $valor;
    }

    public function insertarDetVenta($detVenta) {
        $conexion = new Conexion();

        $conexion->query = "INSERT INTO tbl_det_ventas (IdCabVenta, IdProducto, Cantidad, PrecioUnitario, EstadoDetVenta)
                            VALUES (:idCabVenta, :idProducto, :cantidad, :precioUnitario, :estado)";

        return $conexion->execute_query([
            ':idCabVenta' => $detVenta['IdCabVenta'],
            ':idProducto' => $detVenta['IdProducto'],
            ':cantidad' => $detVenta['Cantidad'],
            ':precioUnitario' => $detVenta['PrecioUnitario'],
            ':estado' => 'Activo'
        ]);
    }

    public function obtenerDetVentaPorId($idDetVenta) {
        $conexion = new Conexion();

        $conexion->query = "SELECT dv.IdDetVenta, dv.IdCabVenta, dv.IdProducto, p.NombreProducto,
                            dv.Cantidad, dv.PrecioUnitario, dv.EstadoDetVenta
                            FROM tbl_det_ventas dv
                            LEFT JOIN tbl_productos p ON dv.IdProducto = p.IdProducto
                            WHERE dv.IdDetVenta = :idDetVenta";

        return $conexion->get_record([':idDetVenta' => $idDetVenta]);
    }

    public function actualizarDetVenta($detVenta) {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_det_ventas
                            SET IdCabVenta = :idCabVenta,
                                IdProducto = :idProducto,
                                Cantidad = :cantidad,
                                PrecioUnitario = :precioUnitario
                            WHERE IdDetVenta = :idDetVenta";

        return $conexion->execute_query([
            ':idCabVenta' => $detVenta['IdCabVenta'],
            ':idProducto' => $detVenta['IdProducto'],
            ':cantidad' => $detVenta['Cantidad'],
            ':precioUnitario' => $detVenta['PrecioUnitario'],
            ':idDetVenta' => $detVenta['IdDetVenta']
        ]);
    }

    public function eliminarDetVenta($idDetVenta) {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_det_ventas SET EstadoDetVenta = 'Eliminado' WHERE IdDetVenta = :idDetVenta";

        return $conexion->execute_query([':idDetVenta' => $idDetVenta]);
    }
}
