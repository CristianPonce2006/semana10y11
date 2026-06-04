<?php
require_once __DIR__.'/../datos/CategoriaDatos.php';

class CategoriaNegocio{

    private $categoriaDatos;

    public function __construct() {
        $this->categoriaDatos = new CategoriaDatos();
    }

    public function listarCategorias() {
        return $this->categoriaDatos->listarCategorias();
    }

    public function limpiarDatos($datos) {
        return [
            'NombreCategoria' => trim($datos['NombreCategoria'])
         ];
    }
    private function validarCategoria($datos) {
        $errores = [];

        if (!isset($datos['NombreCategoria']) || empty(trim($datos['NombreCategoria']))) {
            $errores[] = "El nombre de la categoría es obligatorio.";
        }

        if (isset($datos['NombreCategoria']) && strlen(trim($datos['NombreCategoria'])) > 255) {
            $errores[] = "El nombre de la categoría no debe superar los 255 caracteres.";
        }

        return $errores;
    }
    public function crearCategoria($datos) {
        $errores = $this->validarCategoria($datos);

        if (!empty($errores)) {
            return ['exito' => false, 'errores' => $errores];
        }

        $resultado = $this->categoriaDatos->insertarCategoria($datos);

        return [
            'exito' => $resultado,
            'errores' => $resultado ? [] : ['Error al insertar la categoría en la base de datos.']
        ];
    }

    public function obtenerCategoriaPorId(int $idCategoria) {
        if(!is_numeric($idCategoria) || $idCategoria <= 0) {
            return null;
        }
        return $this->categoriaDatos->obtenerCategoriaPorId($idCategoria);
    }

    public function actualizarCategoria($datos) {
        $errores = $this->validarCategoria($datos);

        if (!isset($datos['IdCategoria']) || empty($datos['IdCategoria'])) {
            $errores[] = "El identificador de la categoría es obligatorio.";
        }

        if (!empty($errores)) {
            return [
                'exito' => false,
                'errores' => $errores
            ];
        }

        $categoria = $this->limpiarDatos($datos);
        $categoria['IdCategoria'] = (int) $datos['IdCategoria'];

        $resultado = $this->categoriaDatos->actualizarCategoria($categoria);

        return [
            'exito' => $resultado,
            'errores' => $resultado ? [] : ['Error al actualizar la categoría en la base de datos.']
        ];
    }

    public function eliminarCategoria($idCategoria) {
        if(!is_numeric($idCategoria) || $idCategoria <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'Identificador de categoría inválido.'
            ];
        }

        $resultado = $this->categoriaDatos->eliminarCategoria($idCategoria);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Categoría eliminada correctamente.' : 'No se pudo eliminar la categoría.'
        ];
    }
}