<?php
require_once __DIR__.'/Conexion.php';

class UsuarioDatos {
    public function listarUsuarios() {
        $conexion = new Conexion();

        $conexion->query = "SELECT IdUsuario, NombreCompleto
                            FROM tbl_usuarios
                            WHERE EstadoUsuario = 'Activo'
                            ORDER BY NombreCompleto ASC";

        return $conexion->get_records();
    }

    public function obtenerUsuarioPorId($idUsuario) {
        $conexion = new Conexion();

        $conexion->query = "SELECT IdUsuario, NombreCompleto, Usuario, TipoCuenta, EstadoUsuario
                            FROM tbl_usuarios
                            WHERE IdUsuario = :idUsuario";

        return $conexion->get_record([':idUsuario' => $idUsuario]);
    }

    public function obtenerUsuarioPorNombre($nombreUsuario) {
        $conexion = new Conexion();

        $conexion->query = "SELECT IdUsuario, NombreCompleto, Usuario, Password, TipoCuenta
                            FROM tbl_usuarios
                            WHERE Usuario = :nombreUsuario AND EstadoUsuario = 'Activo' LIMIT 1";

        $resultado = $conexion->get_record([':nombreUsuario' => $nombreUsuario]);
        return $resultado ? $resultado : null;
    }
    
}
