<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/semana11y12/presentacion/admin/index.php">
            <strong>Sistema de Ventas - Admin</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarCatalogo" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Catálogo
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarCatalogo">
                        <li><a class="dropdown-item" href="/semana11y12/presentacion/admin/productos/listar.php">Productos</a></li>
                        <li><a class="dropdown-item" href="/semana11y12/presentacion/admin/categorias/listar.php">Categorías</a></li>
                        <li><a class="dropdown-item" href="/semana11y12/presentacion/admin/marcas/listar.php">Marcas</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarVentas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Ventas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarVentas">
                        <li><a class="dropdown-item" href="/semana11y12/presentacion/admin/CabVentas/listar.php">Cabeceras de Venta</a></li>
                        <li><a class="dropdown-item" href="/semana11y12/presentacion/admin/detVentas/listar.php">Detalles de Venta</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/semana11y12/presentacion/admin/clientes/listar.php">Clientes</a>
                </li>
            </ul>
            <div class="d-flex align-items-center">
                <span class="navbar-text text-light me-3">
                    <?php echo htmlspecialchars($_SESSION['nombreCompleto'] ?? 'Usuario', ENT_QUOTES, 'UTF-8'); ?>
                </span>
                <a href="/semana11y12/presentacion/cerrar_sesion.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
            </div>
        </div>
    </div>
</nav>
