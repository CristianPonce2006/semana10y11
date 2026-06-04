<?php
require_once __DIR__ . '/../../../negocio/ProductoNegocio.php';

$productoNegocio = new ProductoNegocio();

$idProducto = $_GET['id'] ?? null;

if (!$idProducto) {
    header('Location: listar.php');
    exit;
}

$producto = $productoNegocio->obtenerProductoPorId((int)$idProducto);

if (!$producto) {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = $_POST['IdProducto'] ?? null;
    $resultado = $productoNegocio->eliminarProducto((int)$idProducto);

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
    <title>Eliminar producto</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Eliminar producto</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    ¿Está seguro de eliminar el siguiente producto?
                </div>
                <p><strong>Producto:</strong> <?php echo mostrarValor($producto['NombreProducto']); ?></p>
                <p><strong>Modelo:</strong> <?php echo mostrarValor($producto['Modelo']); ?></p>
                <p><strong>Categoría:</strong> <?php echo mostrarValor($producto['NombreCategoria']); ?></p>
                <p><strong>Marca:</strong> <?php echo mostrarValor($producto['NombreMarca']); ?></p>
                <form method="POST" action="eliminar.php?id=<?php echo mostrarValor($producto['IdProducto']); ?>">
                    <input type="hidden" name="IdProducto" value="<?php echo mostrarValor($producto['IdProducto']); ?>">
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
