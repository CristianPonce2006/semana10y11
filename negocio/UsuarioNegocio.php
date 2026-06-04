<?php
require_once __DIR__.'/../datos/UsuarioDatos.php';

class UsuarioNegocio {
    private $usuarioDatos;

    public function __construct() {
        $this->usuarioDatos = new UsuarioDatos();
    }

    public function listarUsuarios() {
        return $this->usuarioDatos->listarUsuarios();
    }

    public function obtenerUsuarioPorId(int $idUsuario) {
        if (!is_numeric($idUsuario) || $idUsuario <= 0) {
            return null;
        }

        return $this->usuarioDatos->obtenerUsuarioPorId($idUsuario);
    }
}
