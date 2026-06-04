<?php

require_once __DIR__.'/../../../negocio/ClienteNegocio.php';
$clienteNegocio = new ClienteNegocio();

$errores = [];
$mensaje = "";

$datos = [
    'NombreCliente' => '',
    'DUI' => '',
    'NIT' => '',
    'Telefono' => '',
    'Direccion' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'NombreCliente' => $_POST['NombreCliente'] ?? '',
        'DUI' => $_POST['DUI'] ?? '',
        'NIT' => $_POST['NIT'] ?? '',
        'Telefono' => $_POST['Telefono'] ?? '',
        'Direccion' => $_POST['Direccion'] ?? ''
    ];

    $resultado = $clienteNegocio->crearCliente($datos);

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
<html Lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar cliente</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar cliente</h4>
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
                        <label for="nombre" class="form-label">Nombre del cliente</label>
                        <input type="text" class="form-control" id="nombre" name="NombreCliente" required>
                    </div>

                    <div class="mb-3">
                        <label for="dui" class="form-label">DUI</label>
                        <input type="text" class="form-control" id="dui" name="DUI" placeholder="12345678-9">
                    </div>

                    <div class="mb-3">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" class="form-control" id="nit" name="NIT">
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="Telefono" placeholder="7777-8888">
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="Direccion" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">Guardar cliente</button>
                    <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                </form>

            </div>
        </div>
    </div>
<script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

