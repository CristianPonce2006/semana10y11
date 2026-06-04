<?php
require_once __DIR__.'/../includes/seguridad.php';

if($_SESSION['tipoCuenta'] !== 'ADMINISTRADOR') {
    header('Location: ../../login.php?mensaje=Acceso denegado');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="../../public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/estilos.css">
</head>

<body>

    <?php require_once __DIR__.'/../includes/navbaradmin.php'; ?>

    <div class="container mt-4">
        <div class="alert alert-success">
            Bienvenido administrador:
            <strong><?php echo htmlspecialchars($_SESSION['nombreCompleto'], ENT_QUOTES, 'UTF-8'); ?></strong>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3>Panel de Administración</h3>
                <p class="mb-0">
                    Desde este módulo se podrán gestionar productos, categorías,
                    marcas, usuarios, clientes y reportes administrativos.
                </p>
            </div>
        </div>
    </div>

    <script src="../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>