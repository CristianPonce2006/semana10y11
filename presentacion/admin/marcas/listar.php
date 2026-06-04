<?php

require_once __DIR__.'/../../../negocio/MarcaNegocio.php';
$mensaje = $_GET['mensaje'] ?? '';
$marcaNegocio = new MarcaNegocio();

$marcas = $marcaNegocio->listarMarcas();


function mostrarValor($valor){
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de marcas</title>
</head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Administración de marcas</h3>
                <a href="crear.php" class="btn btn-primary">Nueva marca</a>
            </div>
                <?php if ($mensaje === 'creado'): ?>
                    <div class="alert alert-success">Marca registrada correctamente.</div>
                <?php elseif ($mensaje === 'actualizado'): ?>
                    <div class="alert alert-success">Marca actualizada correctamente.</div>
                <?php elseif ($mensaje === 'eliminado'): ?>
                    <div class="alert alert-success">Marca eliminada correctamente.</div>
                <?php endif; ?>


            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    Marcas registradas
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($marcas)): ?>
                            <?php foreach ($marcas as $marca): ?>
                                <tr>
                                    <td><?php echo mostrarValor($marca['IdMarca']); ?></td>
                                    <td><?php echo mostrarValor($marca['NombreMarca']); ?></td>
                                    <td>
                                        <span class="badge bg-success"><?php echo mostrarValor($marca['EstadoMarca']); ?></span>
                                    </td>
                                    <td>
                                        <a href="editar.php?id=<?php echo $marca['IdMarca']; ?>" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                         <a href="eliminar.php?id=<?php echo $marca['IdMarca']; ?>" class="btn btn-danger btn-sm">
                                            Eliminar
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">
                                        No hay marcas registradas
                                    </td>
                                </tr>
                        <?php endif; ?>
                    </tbody>

                    </table>
                </div>
            </div>


        </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
