<?php
require_once __DIR__.'/../../../negocio/CabVentaNegocio.php';

$cabVentaNegocio = new CabVentaNegocio();
$mensaje = $_GET['mensaje'] ?? '';
$ventas = $cabVentaNegocio->listarCabVentas();

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
    <title>Listado de ventas</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Administración de ventas</h3>
            <a href="crear.php" class="btn btn-primary">Nueva venta</a>
        </div>

        <?php if ($mensaje === 'creado'): ?>
            <div class="alert alert-success">Venta registrada correctamente.</div>
        <?php elseif ($mensaje === 'actualizado'): ?>
            <div class="alert alert-success">Venta actualizada correctamente.</div>
        <?php elseif ($mensaje === 'eliminado'): ?>
            <div class="alert alert-success">Venta eliminada correctamente.</div>
        <?php endif; ?>

        <div class="card shadow mb-3">
            <div class="card-body">
                <input type="text" id="buscador" class="form-control" placeholder="Buscar por ID, fecha, cliente o vendedor...">
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                Ventas registradas
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Estado</th>
                            <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($ventas)): ?>
                            <?php foreach ($ventas as $venta): ?>
                                <tr class="fila-venta"
                                    data-id="<?php echo mostrarValor($venta['IdCabVenta']); ?>"
                                    data-fecha="<?php echo mostrarValor(strtolower($venta['FechaVenta'])); ?>"
                                    data-cliente="<?php echo mostrarValor(strtolower($venta['NombreCliente'] ?? $venta['IdCliente'])); ?>"
                                    data-vendedor="<?php echo mostrarValor(strtolower($venta['NombreVendedor'] ?? $venta['IdVendedor'])); ?>">
                                    <td><?php echo mostrarValor($venta['IdCabVenta']); ?></td>
                                    <td><?php echo mostrarValor($venta['FechaVenta']); ?></td>
                                    <td><?php echo mostrarValor($venta['NombreCliente'] ?? $venta['IdCliente']); ?></td>
                                    <td><?php echo mostrarValor($venta['NombreVendedor'] ?? $venta['IdVendedor']); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $venta['EstadoCabVenta'] === 'Activo' ? 'success' : 'secondary'; ?>">
                                            <?php echo mostrarValor($venta['EstadoCabVenta']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="editar.php?id=<?php echo mostrarValor($venta['IdCabVenta']); ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="eliminar.php?id=<?php echo mostrarValor($venta['IdCabVenta']); ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No hay ventas registradas.</td>
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
            const filas = document.querySelectorAll('.fila-venta');
            let filasVisibles = 0;

            filas.forEach(fila => {
                const id = fila.getAttribute('data-id') || '';
                const fecha = fila.getAttribute('data-fecha') || '';
                const cliente = fila.getAttribute('data-cliente') || '';
                const vendedor = fila.getAttribute('data-vendedor') || '';

                if (id.includes(busqueda) || fecha.includes(busqueda) || cliente.includes(busqueda) || vendedor.includes(busqueda)) {
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
                    celda.colSpan = 6;
                    celda.className = 'text-center';
                    fila.id = 'mensajeVacio';
                    mensajeVacio = fila;
                }
                mensajeVacio.style.display = '';
                mensajeVacio.querySelector('td').textContent = busqueda.length > 0 ? 'No se encontraron ventas con ese criterio de búsqueda.' : 'No hay ventas registradas.';
            } else if (mensajeVacio) {
                mensajeVacio.style.display = 'none';
            }
        });
    </script>
</body>
</html>
