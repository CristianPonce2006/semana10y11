<?php
require_once __DIR__.'/../../../negocio/CabVentaNegocio.php';

$cabVentaNegocio = new CabVentaNegocio();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCabVenta = $_POST['IdCabVenta'] ?? null;
    $resultado = $cabVentaNegocio->eliminarCabVenta((int)$idCabVenta);

    if ($resultado['exito']) {
        header('Location: listar.php?mensaje=eliminado');
        exit;
    }
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
    <title>Eliminar venta</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Eliminar venta</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    ¿Está seguro de eliminar la siguiente venta?
                </div>
                <p><strong>ID:</strong> <?php echo mostrarValor($venta['IdCabVenta']); ?></p>
                <p><strong>Fecha:</strong> <?php echo mostrarValor($venta['FechaVenta']); ?></p>
                <p><strong>Cliente:</strong> <?php echo mostrarValor($venta['NombreCliente'] ?? $venta['IdCliente']); ?></p>
                <p><strong>Vendedor:</strong> <?php echo mostrarValor($venta['NombreVendedor'] ?? $venta['IdVendedor']); ?></p>
                <form method="POST" action="eliminar.php?id=<?php echo mostrarValor($venta['IdCabVenta']); ?>">
                    <input type="hidden" name="IdCabVenta" value="<?php echo mostrarValor($venta['IdCabVenta']); ?>">
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
