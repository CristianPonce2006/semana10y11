<?php

require_once __DIR__ . '/../../../negocio/ClienteNegocio.php';

$clienteNegocio = new ClienteNegocio();

$errores = [];

$idCliente = $_GET['id'] ?? null;

if (!$idCliente) {
    header("Location: listar.php");
    exit;
}

$cliente = $clienteNegocio->obtenerClientePorId($idCliente);

if (!$cliente) {
    header("Location: listar.php");
    exit;
}

function mostrarValor($valor)
{
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'IdCliente' => $idCliente,
        'NombreCliente' => $_POST['NombreCliente'] ?? '',
        'DUI' => $_POST['DUI'] ?? '',
        'NIT' => $_POST['NIT'] ?? '',
        'Telefono' => $_POST['Telefono'] ?? '',
        'Direccion' => $_POST['Direccion'] ?? '',
        'Tipo' => $_POST['Tipo'] ?? null,
        'NRC' => $_POST['NRC'] ?? ''
    ];

    $resultado = $clienteNegocio->actualizarCliente($datos);

    if ($resultado['exito']) {
        header("Location: listar.php?mensaje=actualizado");
        exit();
    } else {
        $errores = $resultado['errores'];
        $cliente = $datos;
    }
}
?>

<!DOCTYPE html>
<html Lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar cliente</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Editar cliente</h4>
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
                    <label class="form-label">Estado del cliente</label>
                    <div><span class="badge bg-<?php echo $cliente['EstadoCliente'] === 'Activo' ? 'success' : 'secondary'; ?>"><?php echo mostrarValor($cliente['EstadoCliente']); ?></span></div>
                </div>
                <form action="editar.php?id=<?php echo mostrarValor($cliente['IdCliente']); ?>" method="POST">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del cliente</label>
                        <input type="text" class="form-control" id="nombre" name="NombreCliente"
                            value="<?php echo mostrarValor($cliente['NombreCliente']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select id="tipo" name="Tipo" class="form-select">
                            <option value="PN" <?php echo ($cliente['Tipo'] === 'PN') ? 'selected' : ''; ?>>Persona Natural (PN)</option>
                            <option value="PJ" <?php echo ($cliente['Tipo'] === 'PJ') ? 'selected' : ''; ?>>Persona Jurídica (PJ)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="NRC" class="form-label">NRC</label>
                        <input type="text" class="form-control" id="NRC" name="NRC" maxlength="15" value="<?php echo mostrarValor($cliente['NRC']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="dui" class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="DUI"
                            value="<?php echo mostrarValor($cliente['DUI']); ?>" placeholder="12345678-9">
                    </div>

                    <div class="mb-3">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="nit" name="NIT"
                            value="<?php echo mostrarValor($cliente['NIT']); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="Telefono"
                            value="<?php echo mostrarValor($cliente['Telefono']); ?>" placeholder="7777-8888">
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="Direccion" rows="3"><?php echo mostrarValor($cliente['Direccion']); ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Actualizar cliente</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>
</div>
</div>
</div>
<script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
