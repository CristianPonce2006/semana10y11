<?php
require_once __DIR__.'/../../../negocio/ProductoNegocio.php';
require_once __DIR__.'/../../../negocio/CategoriaNegocio.php';
require_once __DIR__.'/../../../negocio/MarcaNegocio.php';

$productoNegocio = new ProductoNegocio();
$categoriaNegocio = new CategoriaNegocio();
$marcaNegocio = new MarcaNegocio();

$errores = [];

$categorias = $categoriaNegocio->listarCategorias();
$marcas = $marcaNegocio->listarMarcas();

$datos = [
    'NombreProducto' => '',
    'Modelo' => '',
    'IdCategoria' => '',
    'IdMarca' => '',
    'PrecioVenta' => '',
    'Caracteristicas' => '',
    'Existencias' => '',
    'Imagen' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'NombreProducto' => $_POST['NombreProducto'] ?? '',
        'Modelo' => $_POST['Modelo'] ?? '',
        'IdCategoria' => $_POST['IdCategoria'] ?? '',
        'IdMarca' => $_POST['IdMarca'] ?? '',
        'PrecioVenta' => $_POST['PrecioVenta'] ?? '',
        'Caracteristicas' => $_POST['Caracteristicas'] ?? '',
        'Existencias' => $_POST['Existencias'] ?? '',
        'Imagen' => $_POST['Imagen'] ?? ''
    ];

    $resultado = $productoNegocio->crearProducto($datos);

    if ($resultado['exito']) {
        header('Location: listar.php?mensaje=creado');
        exit();
    } else {
        $errores = $resultado['errores'];
    }
}

function mostrarValor($valor) {
    return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar producto</title>
    <link rel="stylesheet" href="../../../public/bootstrap/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Registrar producto</h4>
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
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre del producto</label>
                            <input type="text" class="form-control" id="nombre" name="NombreProducto" value="<?php echo mostrarValor($datos['NombreProducto']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="Modelo" value="<?php echo mostrarValor($datos['Modelo']); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select id="categoria" name="IdCategoria" class="form-select" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo mostrarValor($categoria['IdCategoria']); ?>" <?php echo ($categoria['IdCategoria'] == $datos['IdCategoria']) ? 'selected' : ''; ?>><?php echo mostrarValor($categoria['NombreCategoria']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="marca" class="form-label">Marca</label>
                            <select id="marca" name="IdMarca" class="form-select" required>
                                <option value="">Seleccione una marca</option>
                                <?php foreach ($marcas as $marca): ?>
                                    <option value="<?php echo mostrarValor($marca['IdMarca']); ?>" <?php echo ($marca['IdMarca'] == $datos['IdMarca']) ? 'selected' : ''; ?>><?php echo mostrarValor($marca['NombreMarca']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="precio" class="form-label">Precio de venta</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="precio" name="PrecioVenta" value="<?php echo mostrarValor($datos['PrecioVenta']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="existencias" class="form-label">Existencias</label>
                            <input type="number" step="1" min="0" class="form-control" id="existencias" name="Existencias" value="<?php echo mostrarValor($datos['Existencias']); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="imagen" class="form-label">Nombre de la imagen</label>
                            <input type="text" class="form-control" id="imagen" name="Imagen" value="<?php echo mostrarValor($datos['Imagen']); ?>" placeholder="sin-imagen.png">
                        </div>
                        <div class="col-12">
                            <label for="caracteristicas" class="form-label">Características</label>
                            <textarea class="form-control" id="caracteristicas" name="Caracteristicas" rows="4"><?php echo mostrarValor($datos['Caracteristicas']); ?></textarea>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">Guardar producto</button>
                        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../../../public/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
