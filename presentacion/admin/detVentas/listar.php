<?php
require_once __DIR__.'/../../../negocio/DetVentaNegocio.php';

$detVentaNegocio = new DetVentaNegocio();
$mensaje = $_GET['mensaje'] ?? '';
$detVentas = $detVentaNegocio->listarDetVentas();

function mostrarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
    <title>Listado de detalles de venta</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Detalles de venta</h3>
            <a href="crear.php" class="btn btn-primary">Nuevo detalle</a>
        </div>

        <?php if ($mensaje === 'creado'): ?>
            <div class="alert alert-success">Detalle de venta registrado correctamente.</div>
        <?php elseif ($mensaje === 'actualizado'): ?>
            <div class="alert alert-success">Detalle de venta actualizado correctamente.</div>
        <?php elseif ($mensaje === 'eliminado'): ?>
            <div class="alert alert-success">Detalle de venta eliminado correctamente.</div>
        <?php endif; ?>

        <div class="card shadow mb-3">
            <div class="card-body">
                <input type="text" id="buscador" class="form-control" placeholder="Buscar por ID, cabecera, producto o cantidad...">
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                Líneas de venta registradas
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Cabecera</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio unitario</th>
                            <th>Estado</th>
                            <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($detVentas)): ?>
                            <?php foreach ($detVentas as $detalle): ?>
                                <tr class="fila-detventa"
                                    data-id="<?php echo mostrarValor($detalle['IdDetVenta']); ?>"
                                    data-cab="<?php echo mostrarValor(strtolower($detalle['IdCabVenta'])); ?>"
                                    data-producto="<?php echo mostrarValor(strtolower($detalle['NombreProducto'] ?? $detalle['IdProducto'])); ?>"
                                    data-cantidad="<?php echo mostrarValor(strtolower($detalle['Cantidad'])); ?>">
                                    <td><?php echo mostrarValor($detalle['IdDetVenta']); ?></td>
                                    <td><?php echo mostrarValor($detalle['IdCabVenta']); ?></td>
                                    <td><?php echo mostrarValor($detalle['NombreProducto'] ?? $detalle['IdProducto']); ?></td>
                                    <td><?php echo mostrarValor($detalle['Cantidad']); ?></td>
                                    <td><?php echo mostrarValor(number_format($detalle['PrecioUnitario'], 2)); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $detalle['EstadoDetVenta'] === 'Activo' ? 'success' : 'secondary'; ?>">
                                            <?php echo mostrarValor($detalle['EstadoDetVenta']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="editar.php?id=<?php echo mostrarValor($detalle['IdDetVenta']); ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="eliminar.php?id=<?php echo mostrarValor($detalle['IdDetVenta']); ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay detalles de venta registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            const busqueda = this.value.toLowerCase();
            const filas = document.querySelectorAll('.fila-detventa');
            let filasVisibles = 0;

            filas.forEach(fila => {
                const id = fila.getAttribute('data-id') || '';
                const cab = fila.getAttribute('data-cab') || '';
                const producto = fila.getAttribute('data-producto') || '';
                const cantidad = fila.getAttribute('data-cantidad') || '';

                if (id.includes(busqueda) || cab.includes(busqueda) || producto.includes(busqueda) || cantidad.includes(busqueda)) {
                    fila.style.display = '';
                    filasVisibles++;
                } else {
                    fila.style.display = 'none';
                }
            });

            let mensajeVacio = document.getElementById('mensajeVacio');
            if (filasVisibles === 0) {
                if (!mensajeVacio) {
                    const tbody = document.querySelector('tbody');
                    const fila = tbody.insertRow();
                    const celda = fila.insertCell(0);
                    celda.colSpan = 7;
                    celda.className = 'text-center';
                    fila.id = 'mensajeVacio';
                    mensajeVacio = fila;
                }
                mensajeVacio.style.display = '';
                mensajeVacio.querySelector('td').textContent = busqueda.length > 0 ? 'No se encontraron detalles con ese criterio de búsqueda.' : 'No hay detalles de venta registrados.';
            } else if (mensajeVacio) {
                mensajeVacio.style.display = 'none';
            }
        });
    </script>
</body>
</html>
