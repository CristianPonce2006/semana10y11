<?php

require_once __DIR__ . '/../../../negocio/MarcaNegocio.php';

$marcaNegocio = new MarcaNegocio();

$errores = [];

$idMarca = $_GET['id'] ?? null;

if (!$idMarca) {
    header("Location: listar.php");
    exit;
}

$marca = $marcaNegocio->obtenerMarcaPorId($idMarca);

if (!$marca) {
    header("Location: listar.php");
    exit;
}

function mostrarValor($valor)
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'IdMarca' => $idMarca,
        'NombreMarca' => $_POST['NombreMarca'] ?? ''
    ];

    $resultado = $marcaNegocio->actualizarMarca($datos);

    if ($resultado['exito']) {
        header("Location: listar.php?mensaje=actualizado");
        exit();
    } else {
        $errores = $resultado['errores'];
        $marca = $datos;
    }
}
?>

<!DOCTYPE html>
<html Lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar marca</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Editar marca</h4>
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
                <form action="editar.php?id=<?php echo mostrarValor($marca['IdMarca']); ?>" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la marca</label>
                        <input type="text" class="form-control" id="nombre" name="NombreMarca"
                            value="<?php echo mostrarValor($marca['NombreMarca']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-success">Actualizar marca</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
</div>
</div>
</div>
<script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
