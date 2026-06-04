<?php

require_once __DIR__.'/../includes/seguridad.php';

if($_SESSION['tipoCuenta'] !== 'VENDEDOR') {
    header('Location: ../../login.php?mensaje=Acceso denegado');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Vendedor</title>
    <link rel="stylesheet" href="../../public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/estilos.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <span class="navbar-brand">Sistema de Ventas - Vendedor</span>
            <a href="../cerrar_sesion.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="alert alert-success">
            Bienvenido vendedor:
            <strong><?php echo htmlspecialchars($_SESSION['nombreCompleto'], ENT_QUOTES, 'UTF-8'); ?></strong>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3>Panel de Vendedor</h3>
                <p class="mb-0">
                    Desde este módulo se podrán registrar ventas, consultar productos disponibles y atender clientes.
                </p>
            </div>
        </div>
    </div>

    <script src="../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>