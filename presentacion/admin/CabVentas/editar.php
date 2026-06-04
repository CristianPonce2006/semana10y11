<?php
require_once __DIR__.'/../../../negocio/CabVentaNegocio.php';
require_once __DIR__.'/../../../negocio/ClienteNegocio.php';
require_once __DIR__.'/../../../negocio/UsuarioNegocio.php';

$cabVentaNegocio = new CabVentaNegocio();
$clienteNegocio = new ClienteNegocio();
$usuarioNegocio = new UsuarioNegocio();

$errores = [];
$idCabVenta = $_GET['id'] ?? null;
if (!$idCabVenta) {
    header('Location: listar.php');
    exit;
}

$venta = $cabVentaNegocio->obtenerCabVentaPorId((int)$idCabVenta);
if (!$venta) {
    header('Location: listar.php');
    exit;
}

$clientes = $clienteNegocio->listarClientes();
$vendedores = $usuarioNegocio->listarUsuarios();

$selectedFecha = date('Y-m-d\TH:i', strtotime($venta['FechaVenta']));
$selectedCliente = $venta['IdCliente'];
$selectedVendedor = $venta['IdVendedor'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venta = [
        'IdCabVenta' => (int)$idCabVenta,
        'FechaVenta' => $_POST['FechaVenta'] ?? '',
        'IdCliente' => $_POST['IdCliente'] ?? '',
        'IdVendedor' => $_POST['IdVendedor'] ?? ''
    ];

    $selectedFecha = $_POST['FechaVenta'] ?? $selectedFecha;
    $selectedCliente = $_POST['IdCliente'] ?? $selectedCliente;
    $selectedVendedor = $_POST['IdVendedor'] ?? $selectedVendedor;

    $resultado = $cabVentaNegocio->actualizarCabVenta($venta);

    if ($resultado['exito']) {
        header('Location: listar.php?mensaje=actualizado');
        exit();
    }

    $errores = $resultado['errores'];
}

function mostrarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
    <title>Editar venta</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar venta</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($errores)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errores as $error): ?>
                                <li><?php echo mostrarValor($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="editar.php?id=<?php echo mostrarValor($venta['IdCabVenta']); ?>" method="POST">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="fecha" class="form-label">Fecha de venta</label>
                            <input type="datetime-local" class="form-control" id="fecha" name="FechaVenta" value="<?php echo mostrarValor($selectedFecha); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="cliente" class="form-label">Cliente</label>
                            <select id="cliente" name="IdCliente" class="form-select" required>
                                <option value="">Seleccione un cliente</option>
                                <?php foreach ($clientes as $cliente): ?>
                                    <option value="<?php echo mostrarValor($cliente['IdCliente']); ?>" <?php echo ($cliente['IdCliente'] == $selectedCliente) ? 'selected' : ''; ?>><?php echo mostrarValor($cliente['NombreCliente']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="vendedor" class="form-label">Vendedor</label>
                            <select id="vendedor" name="IdVendedor" class="form-select" required>
                                <option value="">Seleccione un vendedor</option>
                                <?php if (empty($vendedores)): ?>
                                    <option value="" disabled>No hay vendedores registrados</option>
                                <?php else: ?>
                                    <?php foreach ($vendedores as $vendedor): ?>
                                        <option value="<?php echo mostrarValor($vendedor['IdUsuario']); ?>" <?php echo ($vendedor['IdUsuario'] == $selectedVendedor) ? 'selected' : ''; ?>><?php echo mostrarValor($vendedor['NombreCompleto']); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Actualizar venta</button>
                        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
