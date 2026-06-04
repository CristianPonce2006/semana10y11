<?php

require_once __DIR__ . '/../../../negocio/CategoriaNegocio.php';

$categoriaNegocio = new CategoriaNegocio();

$errores = [];

$idCategoria = $_GET['id'] ?? null;

if (!$idCategoria) {
    header("Location: listar.php");
    exit;
}

$categoria = $categoriaNegocio->obtenerCategoriaPorId($idCategoria);

if (!$categoria) {
    header("Location: listar.php");
    exit;
}

function mostrarValor($valor)
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'IdCategoria' => $idCategoria,
        'NombreCategoria' => $_POST['NombreCategoria'] ?? ''
    ];

    $resultado = $categoriaNegocio->actualizarCategoria($datos);

    if ($resultado['exito']) {
        header("Location: listar.php?mensaje=actualizado");
        exit();
    } else {
        $errores = $resultado['errores'];
        $categoria = $datos;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar categoría</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Editar categoría</h4>
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
                <div class="mb-3">
                    <label class="form-label">Estado de la categoría</label>
                    <div><span class="badge bg-<?php echo $categoria['EstadoCategoria'] === 'Activa' ? 'success' : 'secondary'; ?>"><?php echo mostrarValor($categoria['EstadoCategoria']); ?></span></div>
                </div>
                <form action="editar.php?id=<?php echo mostrarValor($categoria['IdCategoria']); ?>" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la categoría</label>
                        <input type="text" class="form-control" id="nombre" name="NombreCategoria" value="<?php echo mostrarValor($categoria['NombreCategoria']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Actualizar categoría</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
