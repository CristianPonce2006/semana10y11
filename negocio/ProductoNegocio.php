<?php
require_once __DIR__.'/../datos/ProductoDatos.php';

class ProductoNegocio {

    private $productoDatos;

    public function __construct() {
        $this->productoDatos = new ProductoDatos();
    }

    public function listarProductos() {
        return $this->productoDatos->listarProductos();
    }

    private function limpiarDatos($datos) {
        return [
            'NombreProducto' => trim($datos['NombreProducto']),
            'Modelo' => isset($datos['Modelo']) ? trim($datos['Modelo']) : '',
            'IdCategoria' => (int)(trim($datos['IdCategoria'])),
            'IdMarca' => (int)(trim($datos['IdMarca'])),
            'PrecioVenta' => number_format((float)(trim($datos['PrecioVenta'])), 2, '.', ''),
            'Caracteristicas' => isset($datos['Caracteristicas']) ? trim($datos['Caracteristicas']) : '',
            'Existencias' => (int)(trim($datos['Existencias'])),
            'Imagen' => isset($datos['Imagen']) ? trim($datos['Imagen']) : 'sin-imagen.png'
         ];
    }

    private function validarProducto($datos) {
        $errores = [];

        if (!isset($datos['NombreProducto']) || empty(trim($datos['NombreProducto']))) {
            $errores[] = "El nombre del producto es obligatorio.";
        }

        if (isset($datos['NombreProducto']) && strlen(trim($datos['NombreProducto'])) > 255) {
            $errores[] = "El nombre del producto no debe superar los 255 caracteres.";
        }

        if (!isset($datos['IdCategoria']) || empty(trim($datos['IdCategoria']))) {
            $errores[] = "La categoría del producto es obligatoria.";
        }

        if (!isset($datos['IdMarca']) || empty(trim($datos['IdMarca']))) {
            $errores[] = "La marca del producto es obligatoria.";
        }

        if (!isset($datos['PrecioVenta']) || !is_numeric(trim($datos['PrecioVenta']))) {
            $errores[] = "El precio de venta del producto es obligatorio y debe ser un número.";
        }
        if (!isset($datos['Existencias']) || !is_numeric(trim($datos['Existencias']))) {
            $errores[] = "Las existencias del producto son obligatorias y deben ser un número.";
        } else if ((int)trim($datos['Existencias']) < 0) {
            $errores[] = "Las existencias del producto no pueden ser negativas.";
        }

        if(!empty($datos['Imagen']) && strlen(trim($datos['Imagen'])) > 255) {
            $errores[] = "El nombre de la imagen no debe superar los 255 caracteres.";
        }

        return $errores;
    }

    public function crearProducto($datos) {
        $errores = $this->validarProducto($datos);

        if (!empty($errores)) {
            return ['exito' => false, 'errores' => $errores];
        }

        $datosLimpios = $this->limpiarDatos($datos);
        $resultado = $this->productoDatos->insertarProducto($datosLimpios);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Producto registrado exitosamente.' : 'No se pudo registrar el producto.'
        ];
    }

    


}