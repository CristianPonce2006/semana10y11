<?php
require_once __DIR__.'/../datos/MarcaDatos.php';

class MarcaNegocio {

    private $marcaDatos;

    public function __construct() {
        $this->marcaDatos = new MarcaDatos();
    }


    public function listarMarcas() {
        return $this->marcaDatos->listarMarcas();
    }

    private function validarMarca($datos) {
        $errores = [];

        if (!isset($datos['NombreMarca']) || empty(trim($datos['NombreMarca']))) {
            $errores[] = "El nombre de la marca es obligatorio.";
        }

        if (isset($datos['NombreMarca']) && strlen(trim($datos['NombreMarca'])) > 255) {
            $errores[] = "El nombre de la marca no debe superar los 255 caracteres.";
        }

        return $errores;
    }

    public function limpiarDatos($datos) {
        return [
            'NombreMarca' => trim($datos['NombreMarca'])
         ];
    }

    public function crearMarca($datos) {
        $errores = $this->validarMarca($datos);

        if (!empty($errores)) {
            return ['exito' => false, 'errores' => $errores];
        }

        $resultado = $this->marcaDatos->insertarMarca($datos);

        return [
            'exito' => $resultado,
            'errores' => $resultado ? [] : ['Error al insertar la marca en la base de datos.']
        ];
    }

    public function obtenerMarcaPorId(int $idMarca) {
        if(!is_numeric($idMarca) || $idMarca <= 0) {
            return null;
        }
        return $this->marcaDatos->obtenerMarcaPorId($idMarca);
    }

    public function actualizarMarca($datos) {
        $errores = $this->validarMarca($datos);

        if (!empty($errores)) {
            return ['exito' => false, 'errores' => $errores];
        }

        $resultado = $this->marcaDatos->actualizarMarca($datos);

        return [
            'exito' => $resultado,
            'errores' => $resultado ? [] : ['Error al actualizar la marca en la base de datos.']
        ];
    }

    public function eliminarMarca(int $idMarca) {
        if(!is_numeric($idMarca) || $idMarca <= 0) {
            return ['exito' => false, 'errores' => ['Identificador de marca inválido.']];
        }

        $resultado = $this->marcaDatos->eliminarMarca($idMarca);

        return [
            'exito' => $resultado,
            'errores' => $resultado ? [] : ['Error al eliminar la marca de la base de datos.']
         ];
    }

}