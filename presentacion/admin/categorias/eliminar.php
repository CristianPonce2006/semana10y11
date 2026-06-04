<?php

require_once __DIR__ . '/../../../negocio/CategoriaNegocio.php';

$categoriaNegocio = new CategoriaNegocio();

$idCategoria = $_GET['id'] ?? null;

if (!$idCategoria) {
    header('Location: listar.php');
    exit;
}

$categoria = $categoriaNegocio->obtenerCategoriaPorId($idCategoria);

if (!$categoria) {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCategoria = $_POST['IdCategoria'] ?? null;
    $resultado = $categoriaNegocio->eliminarCategoria($idCategoria);

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
    <title>Eliminar categoría</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Eliminar categoría</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    ¿Está seguro de eliminar la siguiente categoría?
                </div>
                <p><strong>Nombre:</strong> <?php echo mostrarValor($categoria['NombreCategoria']); ?></p>
                <p><strong>Estado:</strong> <?php echo mostrarValor($categoria['EstadoCategoria']); ?></p>
                <form method="POST" action="eliminar.php?id=<?php echo mostrarValor($categoria['IdCategoria']); ?>">
                    <input type="hidden" name="IdCategoria" value="<?php echo mostrarValor($categoria['IdCategoria']); ?>">
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
