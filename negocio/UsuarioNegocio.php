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

    

    public function validarLogin(string $usuario, string $password) {
       
        if (empty($usuario) || empty($password)) {
            return null;
        }

       $usuarioEncontrado = $this->usuarioDatos->obtenerUsuarioPorNombre($usuario);
        if ($usuarioEncontrado === null) {
            return null;
        }

        if (!password_verify($password, $usuarioEncontrado['Password'])) {
            return null;
        }

        return $usuarioEncontrado;
    }
}
