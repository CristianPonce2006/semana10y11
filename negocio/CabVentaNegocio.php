<?php
require_once __DIR__.'/../datos/CabVentaDatos.php';
require_once __DIR__.'/UsuarioNegocio.php';
require_once __DIR__.'/ClienteNegocio.php';

class CabVentaNegocio {

    private $cabVentaDatos;
    private $usuarioNegocio;
    private $clienteNegocio;

    public function __construct() {
        $this->cabVentaDatos = new CabVentaDatos();
        $this->usuarioNegocio = new UsuarioNegocio();
        $this->clienteNegocio = new ClienteNegocio();
    }

    public function listarCabVentas() {
        return $this->cabVentaDatos->listarCabVentas();
    }

    private function formatearFecha($fecha) {
        $fecha = trim((string)$fecha);
        if ($fecha === '') {
            return null;
        }

        $date = date_create($fecha);
        return $date ? $date->format('Y-m-d H:i:s') : null;
    }

    private function limpiarDatos($datos) {
        return [
            'FechaVenta' => $this->formatearFecha($datos['FechaVenta'] ?? ''),
            'IdCliente' => isset($datos['IdCliente']) ? (int) trim($datos['IdCliente']) : 0,
            'IdVendedor' => isset($datos['IdVendedor']) ? (int) trim($datos['IdVendedor']) : 0,
        ];
    }

    private function validarCabVenta($datos) {
        $errores = [];

        if (!isset($datos['FechaVenta']) || trim($datos['FechaVenta']) === '') {
            $errores[] = 'La fecha de venta es obligatoria.';
        } elseif (!$this->formatearFecha($datos['FechaVenta'])) {
            $errores[] = 'La fecha de venta debe tener un formato válido.';
        }

        if (!isset($datos['IdCliente']) || trim($datos['IdCliente']) === '' || !is_numeric(trim($datos['IdCliente'])) || (int)trim($datos['IdCliente']) <= 0) {
            $errores[] = 'El cliente de la venta es obligatorio y debe ser válido.';
        } elseif (!$this->clienteNegocio->obtenerClientePorId((int)$datos['IdCliente'])) {
            $errores[] = 'El cliente seleccionado no existe.';
        }

        if (!isset($datos['IdVendedor']) || trim($datos['IdVendedor']) === '' || !is_numeric(trim($datos['IdVendedor'])) || (int)trim($datos['IdVendedor']) <= 0) {
            $errores[] = 'El vendedor de la venta es obligatorio y debe ser válido.';
        } elseif (!$this->usuarioNegocio->obtenerUsuarioPorId((int)$datos['IdVendedor'])) {
            $errores[] = 'El vendedor seleccionado no existe.';
        }

        return $errores;
    }

    public function crearCabVenta($datos) {
        $errores = $this->validarCabVenta($datos);

        if (!empty($errores)) {
            return [
                'exito' => false,
                'errores' => $errores
            ];
        }

        $cabVenta = $this->limpiarDatos($datos);
        $resultado = $this->cabVentaDatos->insertarCabVenta($cabVenta);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Cabecera de venta registrada exitosamente.' : 'No se pudo registrar la cabecera de venta.'
        ];
    }

    public function obtenerCabVentaPorId(int $idCabVenta) {
        if (!is_numeric($idCabVenta) || $idCabVenta <= 0) {
            return null;
        }

        return $this->cabVentaDatos->obtenerCabVentaPorId($idCabVenta);
    }

    public function actualizarCabVenta($datos) {
        $errores = $this->validarCabVenta($datos);

        if (!isset($datos['IdCabVenta']) || trim($datos['IdCabVenta']) === '' || !is_numeric(trim($datos['IdCabVenta'])) || (int)trim($datos['IdCabVenta']) <= 0) {
            $errores[] = 'El identificador de la cabecera de venta es obligatorio.';
        }

        if (!empty($errores)) {
            return [
                'exito' => false,
                'errores' => $errores
            ];
        }

        $cabVenta = $this->limpiarDatos($datos);
        $cabVenta['IdCabVenta'] = (int)$datos['IdCabVenta'];

        $resultado = $this->cabVentaDatos->actualizarCabVenta($cabVenta);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Cabecera de venta actualizada exitosamente.' : 'No se pudo actualizar la cabecera de venta.'
        ];
    }

    public function eliminarCabVenta(int $idCabVenta) {
        if (!is_numeric($idCabVenta) || $idCabVenta <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'Identificador de cabecera de venta no válido.'
            ];
        }

        $resultado = $this->cabVentaDatos->eliminarCabVenta($idCabVenta);

        return [
            'exito' => $resultado,
            'mensaje' => $resultado ? 'Cabecera de venta eliminada correctamente.' : 'No se pudo eliminar la cabecera de venta.'
        ];
    }
}
