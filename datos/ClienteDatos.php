<?php
require_once __DIR__.'/Conexion.php';
class ClienteDatos {
	public function listarClientes(){
        $conexion = new Conexion();

        $conexion->query = "SELECT IdCliente, NombreCliente, DUI, NIT, Telefono, Direccion, EstadoCliente, Tipo, NRC
                            FROM tbl_clientes
                            WHERE EstadoCliente = 'Activo'
                            ORDER BY IdCliente DESC";

        return $conexion->get_records();
    }

    private function valorNulo($valor){
        return trim($valor) ===''? null: $valor;
    }

    public function insertarCliente($cliente)
    {
        $conexion = new Conexion();

        $conexion->query = "INSERT INTO tbl_clientes (NombreCliente, DUI, NIT, Telefono, Direccion, Tipo, NRC)
                            VALUES (:nombre, :dui, :nit, :telefono, :direccion, :tipo, :NRC)";

        return $conexion->execute_query([
            ':nombre'   => $cliente['NombreCliente'],
            ':dui'      => $this->valorNulo($cliente['DUI']),
            ':nit'      => $this->valorNulo($cliente['NIT']),
            ':telefono' => $this->valorNulo($cliente['Telefono']),
            ':direccion'=> $this->valorNulo($cliente['Direccion']),
            ':tipo'     => isset($cliente['Tipo']) ? $cliente['Tipo'] : null,
            ':NRC'      => $this->valorNulo($cliente['NRC'])
        ]);
    }


    public function actualizarCliente($cliente)
    {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_clientes SET NombreCliente = :nombre, DUI = :dui,
                            NIT = :nit, Telefono = :telefono, Direccion = :direccion, Tipo = :tipo, NRC = :NRC
                            WHERE IdCliente = :idCliente";

        return $conexion->execute_query([
            ':nombre'    => $cliente['NombreCliente'],
            ':dui'       => $this->valorNulo($cliente['DUI']),
            ':nit'       => $this->valorNulo($cliente['NIT']),
            ':telefono'  => $this->valorNulo($cliente['Telefono']),
            ':direccion' => $this->valorNulo($cliente['Direccion']),
            ':tipo'      => isset($cliente['Tipo']) ? $cliente['Tipo'] : null,
            ':NRC'       => $this->valorNulo($cliente['NRC']),
            ':idCliente' => $cliente['IdCliente']
        ]);
    }

    public function obtenerClientePorId($idCliente)
    {
        $conexion = new Conexion();

        $conexion->query = "SELECT IdCliente, NombreCliente, DUI, NIT, Telefono, Direccion, EstadoCliente, Tipo, NRC
                            FROM tbl_clientes
                            WHERE IdCliente = :idCliente";

        return $conexion->get_record([':idCliente' => $idCliente]);
    }

    public function eliminarCliente($idCliente)
    {
        $conexion = new Conexion();

        $conexion->query = "UPDATE tbl_clientes SET EstadoCliente = 'Eliminado' WHERE IdCliente = :idCliente";

        return $conexion->execute_query([':idCliente' => $idCliente]);

    
    }


}
