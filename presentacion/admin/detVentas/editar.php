<?php
require_once __DIR__.'/../../../negocio/DetVentaNegocio.php';
require_once __DIR__.'/../../../negocio/CabVentaNegocio.php';
require_once __DIR__.'/../../../negocio/ProductoNegocio.php';

$detVentaNegocio = new DetVentaNegocio();
$cabVentaNegocio = new CabVentaNegocio();
$productoNegocio = new ProductoNegocio();

$errores = [];
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

$cabVentas = $cabVentaNegocio->listarCabVentas();
$productos = $productoNegocio->listarProductos();

$selectedCabVenta = $detalle['IdCabVenta'];
$selectedProducto = $detalle['IdProducto'];
$selectedCantidad = $detalle['Cantidad'];
$selectedPrecio = $detalle['PrecioUnitario'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $detalle = [
        'IdDetVenta' => (int)$idDetVenta,
        'IdCabVenta' => $_POST['IdCabVenta'] ?? '',
        'IdProducto' => $_POST['IdProducto'] ?? '',
        'Cantidad' => $_POST['Cantidad'] ?? '',
        'PrecioUnitario' => $_POST['PrecioUnitario'] ?? ''
    ];

    $selectedCabVenta = $_POST['IdCabVenta'] ?? $selectedCabVenta;
    $selectedProducto = $_POST['IdProducto'] ?? $selectedProducto;
    $selectedCantidad = $_POST['Cantidad'] ?? $selectedCantidad;
    $selectedPrecio = $_POST['PrecioUnitario'] ?? $selectedPrecio;

    $resultado = $detVentaNegocio->actualizarDetVenta($detalle);

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
    <title>Editar detalle de venta</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Editar detalle de venta</h4>
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

                <form action="editar.php?id=<?php echo mostrarValor($detalle['IdDetVenta']); ?>" method="POST">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="cabventa" class="form-label">Cabecera de venta</label>
                            <select id="cabventa" name="IdCabVenta" class="form-select" required>
                                <option value="">Seleccione una cabecera</option>
                                <?php if (empty($cabVentas)): ?>
                                    <option value="" disabled>No hay cabeceras disponibles</option>
                                <?php else: ?>
                                    <?php foreach ($cabVentas as $cabVenta): ?>
                                        <option value="<?php echo mostrarValor($cabVenta['IdCabVenta']); ?>" <?php echo ($cabVenta['IdCabVenta'] == $selectedCabVenta) ? 'selected' : ''; ?>><?php echo mostrarValor($cabVenta['IdCabVenta'] . ' - ' . ($cabVenta['NombreCliente'] ?? 'Cliente')); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="producto" class="form-label">Producto</label>
                            <select id="producto" name="IdProducto" class="form-select" required>
                                <option value="">Seleccione un producto</option>
                                <?php if (empty($productos)): ?>
                                    <option value="" disabled>No hay productos disponibles</option>
                                <?php else: ?>
                                    <?php foreach ($productos as $producto): ?>
                                        <option value="<?php echo mostrarValor($producto['IdProducto']); ?>" <?php echo ($producto['IdProducto'] == $selectedProducto) ? 'selected' : ''; ?>><?php echo mostrarValor($producto['NombreProducto']); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" min="1" step="1" class="form-control" id="cantidad" name="Cantidad" value="<?php echo mostrarValor($selectedCantidad); ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label for="precio" class="form-label">Precio unitario</label>
                            <input type="number" min="0.01" step="0.01" class="form-control" id="precio" name="PrecioUnitario" value="<?php echo mostrarValor($selectedPrecio); ?>" required>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Actualizar detalle</button>
                        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
