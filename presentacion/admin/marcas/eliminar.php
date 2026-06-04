<?php

require_once __DIR__ . '/../../../negocio/MarcaNegocio.php';

$marcaNegocio = new MarcaNegocio();

$idMarca = $_GET['id'] ?? null;

if (!$idMarca) {
    header('Location: listar.php');
    exit;
}

$marca = $marcaNegocio->obtenerMarcaPorId($idMarca);

if (!$marca) {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMarca = $_POST['IdMarca'] ?? null;
    $resultado = $marcaNegocio->eliminarMarca($idMarca);

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
<html Lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar marca</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Eliminar marca</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    ¿Está seguro de eliminar la siguiente marca?
                </div>
                <p><strong>Nombre:</strong> <?php echo mostrarValor($marca['NombreMarca']); ?></p>
                <p><strong>Estado:</strong> <span class="badge bg-success"><?php echo mostrarValor($marca['EstadoMarca']); ?></span></p>
                <form method="POST" action="eliminar.php?id=<?php echo mostrarValor($marca['IdMarca']); ?>">
                    <input type="hidden" name="IdMarca" value="<?php echo mostrarValor($marca['IdMarca']); ?>">
                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
