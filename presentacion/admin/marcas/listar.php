<?php

require_once __DIR__.'/../../../negocio/MarcaNegocio.php';
require_once __DIR__.'/../../includes/navbaradmin.php';
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

            <div class="card shadow mb-3">
                <div class="card-body">
                    <input type="text" id="buscador" class="form-control" placeholder="Buscar por ID o nombre...">
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    Marcas registradas
                </div>

                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="tablaMarcas">
                    <thead class="table-dark">
                        <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <?php if (!empty($marcas)): ?>
                            <?php foreach ($marcas as $marca): ?>
                                <tr class="fila-marca" data-id="<?php echo $marca['IdMarca']; ?>" data-nombre="<?php echo strtolower($marca['NombreMarca']); ?>">
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
                                <tr id="mensajeVacio">
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
    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            const busqueda = this.value.toLowerCase();
            const filas = document.querySelectorAll('.fila-marca');
            let filasVisibles = 0;

            filas.forEach(fila => {
                const id = fila.getAttribute('data-id');
                const nombre = fila.getAttribute('data-nombre');

                if (id.includes(busqueda) || nombre.includes(busqueda)) {
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
                    mensajeVacio.querySelector('td').textContent = 'No se encontraron marcas con ese criterio de búsqueda.';
                } else {
                    mensajeVacio.style.display = 'none';
                }
            } else if (filasVisibles === 0 && busqueda.length === 0) {
                // Si no hay resultados y no hay búsqueda activa, mostrar mensaje original
                const tbody = document.getElementById('cuerpoTabla');
                if (tbody.children.length === 0) {
                    const fila = tbody.insertRow();
                    const celda = fila.insertCell(0);
                    celda.colSpan = 4;
                    celda.textContent = 'No hay marcas registradas';
                    celda.className = 'text-center';
                    celda.id = 'mensajeVacio';
                }
            }
        });
    </script>
</body>
</html>
