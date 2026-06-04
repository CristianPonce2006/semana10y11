<?php
require_once __DIR__.'/../../../negocio/ProductoNegocio.php';

$mensaje = $_GET['mensaje'] ?? '';
$productoNegocio = new ProductoNegocio();
$productos = $productoNegocio->listarProductos();

function mostrarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}

function obtenerImagenProducto($imagen) {
    $imagen = trim((string) $imagen);
    $imagenDefault = '../../../public/img/sin-imagen.png';

    if ($imagen === '') {
        return $imagenDefault;
    }

    $rutaArchivo = __DIR__ . '/../../../public/img/' . $imagen;
    if (!file_exists($rutaArchivo)) {
        return $imagenDefault;
    }

    return '../../../public/img/' . rawurlencode($imagen);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
    <title>Listado de productos</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Administración de productos</h3>
            <a href="crear.php" class="btn btn-primary">Nuevo producto</a>
        </div>

        <?php if ($mensaje === 'creado'): ?>
            <div class="alert alert-success">Producto registrado correctamente.</div>
        <?php elseif ($mensaje === 'actualizado'): ?>
            <div class="alert alert-success">Producto actualizado correctamente.</div>
        <?php elseif ($mensaje === 'eliminado'): ?>
            <div class="alert alert-success">Producto eliminado correctamente.</div>
        <?php endif; ?>

        <div class="card shadow mb-3">
            <div class="card-body">
                <input type="text" id="buscador" class="form-control" placeholder="Buscar por ID, producto, modelo, categoría o marca...">
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                Productos registrados
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Modelo</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Existencias</th>
                            <th width="180">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $producto): ?>
                                <tr class="fila-producto"
                                    data-id="<?php echo mostrarValor($producto['IdProducto']); ?>"
                                    data-producto="<?php echo mostrarValor(strtolower($producto['NombreProducto'])); ?>"
                                    data-modelo="<?php echo mostrarValor(strtolower($producto['Modelo'])); ?>"
                                    data-categoria="<?php echo mostrarValor(strtolower($producto['NombreCategoria'])); ?>"
                                    data-marca="<?php echo mostrarValor(strtolower($producto['NombreMarca'])); ?>">
                                    <td><?php echo mostrarValor($producto['IdProducto']); ?></td>
                                    <td>
                                        <img src="<?php echo mostrarValor(obtenerImagenProducto($producto['Imagen'])); ?>"
                                             alt="Imagen producto" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                    </td>
                                    <td><?php echo mostrarValor($producto['NombreProducto']); ?></td>
                                    <td><?php echo mostrarValor($producto['Modelo']); ?></td>
                                    <td><?php echo mostrarValor($producto['NombreCategoria']); ?></td>
                                    <td><?php echo mostrarValor($producto['NombreMarca']); ?></td>
                                    <td><?php echo number_format((float) $producto['PrecioVenta'], 2, '.', ','); ?></td>
                                    <td><?php echo mostrarValor($producto['Existencias']); ?></td>
                                    <td>
                                        <a href="editar.php?id=<?php echo mostrarValor($producto['IdProducto']); ?>" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="eliminar.php?id=<?php echo mostrarValor($producto['IdProducto']); ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">No hay productos registrados.</td>
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
            const filas = document.querySelectorAll('.fila-producto');
            let filasVisibles = 0;

            filas.forEach(fila => {
                const id = fila.getAttribute('data-id') || '';
                const producto = fila.getAttribute('data-producto') || '';
                const modelo = fila.getAttribute('data-modelo') || '';
                const categoria = fila.getAttribute('data-categoria') || '';
                const marca = fila.getAttribute('data-marca') || '';

                if (
                    id.includes(busqueda) ||
                    producto.includes(busqueda) ||
                    modelo.includes(busqueda) ||
                    categoria.includes(busqueda) ||
                    marca.includes(busqueda)
                ) {
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
                    celda.colSpan = 9;
                    celda.className = 'text-center';
                    fila.id = 'mensajeVacio';
                    mensajeVacio = fila;
                }

                mensajeVacio.style.display = '';
                mensajeVacio.querySelector('td').textContent = busqueda.length > 0
                    ? 'No se encontraron productos con ese criterio de búsqueda.'
                    : 'No hay productos registrados.';
            } else if (mensajeVacio) {
                mensajeVacio.style.display = 'none';
            }
        });
    </script>
</body>
</html>
