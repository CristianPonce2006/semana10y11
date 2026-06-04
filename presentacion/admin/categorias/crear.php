<?php

require_once __DIR__.'/../../../negocio/CategoriaNegocio.php';
$categoriaNegocio = new CategoriaNegocio();

$errores = [];

$datos = [
    'NombreCategoria' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'NombreCategoria' => $_POST['NombreCategoria'] ?? ''
    ];

    $resultado = $categoriaNegocio->crearCategoria($datos);

    if ($resultado['exito']) {
        header("Location: listar.php?mensaje=creado");
        exit();
    } else {
        $errores = $resultado['errores'];
    }
}

function mostrarValor($valor){
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar categoría</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar categoría</h4>
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
                <form action="crear.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la categoría</label>
                        <input type="text" class="form-control" id="nombre" name="NombreCategoria" value="<?php echo mostrarValor($datos['NombreCategoria']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar categoría</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
