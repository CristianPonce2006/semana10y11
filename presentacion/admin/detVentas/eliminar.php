<?php
require_once __DIR__.'/../../../negocio/DetVentaNegocio.php';

$detVentaNegocio = new DetVentaNegocio();

$idDetVenta = $_GET['id'] ?? null;
if (!$idDetVenta) {
    header('Location: listar.php');
    exit;
}

$detalle = $detVentaNegocio->obtenerDetVentaPorId((int)$idDetVenta);
if (!$detalle) {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idDetVenta = $_POST['IdDetVenta'] ?? null;
    $resultado = $detVentaNegocio->eliminarDetVenta((int)$idDetVenta);

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
    <title>Eliminar detalle de venta</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Eliminar detalle de venta</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    ¿Está seguro de eliminar el siguiente detalle de venta?
                </div>

                <p><strong>ID:</strong> <?php echo mostrarValor($detalle['IdDetVenta']); ?></p>
                <p><strong>Cabecera:</strong> <?php echo mostrarValor($detalle['IdCabVenta']); ?></p>
                <p><strong>Producto:</strong> <?php echo mostrarValor($detalle['NombreProducto'] ?? $detalle['IdProducto']); ?></p>
                <p><strong>Cantidad:</strong> <?php echo mostrarValor($detalle['Cantidad']); ?></p>
                <p><strong>Precio unitario:</strong> <?php echo mostrarValor(number_format($detalle['PrecioUnitario'], 2)); ?></p>

                <form method="POST" action="eliminar.php?id=<?php echo mostrarValor($detalle['IdDetVenta']); ?>">
                    <input type="hidden" name="IdDetVenta" value="<?php echo mostrarValor($detalle['IdDetVenta']); ?>">
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
