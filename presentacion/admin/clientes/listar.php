<?php

require_once __DIR__.'/../../../negocio/ClienteNegocio.php';
$mensaje = $_GET['mensaje'] ?? '';
$clienteNegocio = new ClienteNegocio();

$clientes = $clienteNegocio->listarClientes();


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
    <title>Listado de clientes</title>
</head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>Administración de clientes</h3>
                <a href="crear.php" class="btn btn-primary">Nuevo cliente</a>
            </div>
                <?php if ($mensaje === 'creado'): ?>
                    <div class="alert alert-success">Cliente registrado correctamente.</div>
                <?php elseif ($mensaje === 'actualizado'): ?>
                    <div class="alert alert-success">Cliente actualizado correctamente.</div>
                <?php elseif ($mensaje === 'eliminado'): ?>
                    <div class="alert alert-success">Cliente eliminado correctamente.</div>
                <?php endif; ?>

            <div class="card shadow mb-3">
                <div class="card-body">
                    <input type="text" id="buscador" class="form-control" placeholder="Buscar por ID, nombre, DUI o teléfono...">
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    Clientes registrados
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="tablaClientes">
                    <thead class="table-dark">
                        <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>DUI</th>
                        <th>NIT</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <?php if (!empty($clientes)): ?>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr class="fila-cliente" data-id="<?php echo $cliente['IdCliente']; ?>" data-nombre="<?php echo strtolower($cliente['NombreCliente']); ?>" data-dui="<?php echo strtolower($cliente['DUI']); ?>" data-telefono="<?php echo strtolower($cliente['Telefono']); ?>">
                                    <td><?php echo mostrarValor($cliente['IdCliente']); ?></td>
                                    <td><?php echo mostrarValor($cliente['NombreCliente']); ?></td>
                                    <td><?php echo mostrarValor($cliente['DUI']); ?></td>
                                    <td><?php echo mostrarValor($cliente['NIT']); ?></td>
                                    <td><?php echo mostrarValor($cliente['Telefono']); ?></td>
                                    <td><?php echo mostrarValor($cliente['Direccion']); ?></td>
                                    <td>
                                        <a href="editar.php?id=<?php echo $cliente['IdCliente']; ?>" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                         <a href="eliminar.php?id=<?php echo $cliente['IdCliente']; ?>" class="btn btn-danger btn-sm">
                                            Eliminar
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <tr id="mensajeVacio">
                                    <td colspan="7" class="text-center">
                                        No hay clientes registrados
                                    </td>
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
            const filas = document.querySelectorAll('.fila-cliente');
            let filasVisibles = 0;

            filas.forEach(fila => {
                const id = fila.getAttribute('data-id');
                const nombre = fila.getAttribute('data-nombre');
                const dui = fila.getAttribute('data-dui');
                const telefono = fila.getAttribute('data-telefono');

                if (id.includes(busqueda) || nombre.includes(busqueda) || dui.includes(busqueda) || telefono.includes(busqueda)) {
                    fila.style.display = '';
                    filasVisibles++;
                } else {
                    fila.style.display = 'none';
                }
            });

            // Mostrar/ocultar mensaje de sin resultados
            const mensajeVacio = document.getElementById('mensajeVacio');
            if (mensajeVacio) {
                if (filasVisibles === 0 && busqueda.length > 0) {
                    mensajeVacio.style.display = '';
                    mensajeVacio.querySelector('td').textContent = 'No se encontraron clientes con ese criterio de búsqueda.';
                } else {
                    mensajeVacio.style.display = 'none';
                }
            } else if (filasVisibles === 0 && busqueda.length === 0) {
                // Si no hay resultados y no hay búsqueda activa, mostrar mensaje original
                const tbody = document.getElementById('cuerpoTabla');
                if (tbody.children.length === 0) {
                    const fila = tbody.insertRow();
                    const celda = fila.insertCell(0);
                    celda.colSpan = 7;
                    celda.textContent = 'No hay clientes registrados';
                    celda.className = 'text-center';
                    celda.id = 'mensajeVacio';
                }
            }
        });
    </script>
</body>
</html>