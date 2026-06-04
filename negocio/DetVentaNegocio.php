<?php
require_once __DIR__.'/../datos/DetVentaDatos.php';
require_once __DIR__.'/ProductoNegocio.php';
require_once __DIR__.'/CabVentaNegocio.php';

class DetVentaNegocio {
    private $detVentaDatos;
    private $productoNegocio;
    private $cabVentaNegocio;

    public function __construct() {
        $this->detVentaDatos = new DetVentaDatos();
        $this->productoNegocio = new ProductoNegocio();
        $this->cabVentaNegocio = new CabVentaNegocio();
    }

    public function listarDetVentas() {
        return $this->detVentaDatos->listarDetVentas();
    }

    private function limpiarDatos($datos) {
        return [
            'IdCabVenta' => isset($datos['IdCabVenta']) ? (int) trim($datos['IdCabVenta']) : 0,
            'IdProducto' => isset($datos['IdProducto']) ? (int) trim($datos['IdProducto']) : 0,
            'Cantidad' => isset($datos['Cantidad']) ? (int) trim($datos['Cantidad']) : 0,
            'PrecioUnitario' => isset($datos['PrecioUnitario']) ? (float) trim($datos['PrecioUnitario']) : 0.0,
        ];
    }

    private function validarDetVenta($datos) {
        $errores = [];

        if (!isset($datos['IdCabVenta']) || trim($datos['IdCabVenta']) === '' || !is_numeric(trim($datos['IdCabVenta'])) || (int)trim($datos['IdCabVenta']) <= 0) {
            $errores[] = 'La cabecera de venta es obligatoria y debe ser válida.';
        } elseif (!$this->cabVentaNegocio->obtenerCabVentaPorId((int)$datos['IdCabVenta'])) {
            $errores[] = 'La cabecera de venta seleccionada no existe.';
        }

        if (!isset($datos['IdProducto']) || trim($datos['IdProducto']) === '' || !is_numeric(trim($datos['IdProducto'])) || (int)trim($datos['IdProducto']) <= 0) {
            $errores[] = 'El producto es obligatorio y debe ser válido.';
        } elseif (!$this->productoNegocio->obtenerProductoPorId((int)$datos['IdProducto'])) {
            $errores[] = 'El producto seleccionado no existe.';
        }

        if (!isset($datos['Cantidad']) || trim($datos['Cantidad']) === '' || !is_numeric(trim($datos['Cantidad'])) || (int)trim($datos['Cantidad']) <= 0) {
            $errores[] = 'La cantidad debe ser un número entero mayor que cero.';
        }

        if (!isset($datos['PrecioUnitario']) || trim($datos['PrecioUnitario']) === '' || !is_numeric(trim($datos['PrecioUnitario'])) || (float)trim($datos['PrecioUnitario']) <= 0) {
            $errores[] = 'El precio unitario debe ser un número mayor que cero.';
        }

        return $errores;
    }

    public function crearDetVenta($datos) {
        $errores = $this->validarDetVenta($datos);

        if (!empty($errores)) {
            return [
                'exito' => false,
                'errores' => $errores
            ];
        }

        $detVenta = $this->limpiarDatos($datos);
        $resultado = $this->detVentaDatos->insertarDetVenta($detVenta);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Detalle de venta registrado exitosamente.' : 'No se pudo registrar el detalle de venta.'
        ];
    }

    public function obtenerDetVentaPorId(int $idDetVenta) {
        if (!is_numeric($idDetVenta) || $idDetVenta <= 0) {
            return null;
        }

        return $this->detVentaDatos->obtenerDetVentaPorId($idDetVenta);
    }

    public function actualizarDetVenta($datos) {
        $errores = [];

        if (!isset($datos['IdDetVenta']) || trim($datos['IdDetVenta']) === '' || !is_numeric(trim($datos['IdDetVenta'])) || (int)trim($datos['IdDetVenta']) <= 0) {
            $errores[] = 'El identificador del detalle de venta es obligatorio.';
        }

        $errores = array_merge($errores, $this->validarDetVenta($datos));

        if (!empty($errores)) {
            return [
                'exito' => false,
                'errores' => $errores
            ];
        }

        $detVenta = $this->limpiarDatos($datos);
        $detVenta['IdDetVenta'] = (int) $datos['IdDetVenta'];

        $resultado = $this->detVentaDatos->actualizarDetVenta($detVenta);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Detalle de venta actualizado exitosamente.' : 'No se pudo actualizar el detalle de venta.'
        ];
    }

    public function eliminarDetVenta(int $idDetVenta) {
        if (!is_numeric($idDetVenta) || $idDetVenta <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'Identificador de detalle de venta no válido.'
            ];
        }

        $resultado = $this->detVentaDatos->eliminarDetVenta($idDetVenta);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Detalle de venta eliminado correctamente.' : 'No se pudo eliminar el detalle de venta.'
        ];
    }
}
