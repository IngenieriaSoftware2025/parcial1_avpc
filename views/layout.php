<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>Sistema de Tienda</title>
    <style>
        .bg-azul-oscuro {
            background-color: #0a2463;
        }
        .bg-verde-tienda {
            background-color: #28a745;
        }
        .bg-naranja-tienda {
            background-color: #fd7e14;
        }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm bg-azul-oscuro">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/tienda/">
                <img src="<?= asset('images/cit.png') ?>" alt="Logo" width="32" height="32" class="me-2">
                TIENDA INICIO
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/tienda/marcas">
                            <i class="bi bi-tags me-1"></i>Marcas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tienda/productos">
                            <i class="bi bi-box me-1"></i>Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tienda/clientes">
                            <i class="bi bi-people me-1"></i>Clientes
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">
                            <i class="bi bi-gear me-1"></i>Más
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-graph-up me-2"></i>Reportes</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-cart me-2"></i>Ventas</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-tools me-2"></i>Configuración</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <main class="container py-5 my-4 rounded shadow bg-white" style="min-height: 75vh;">
        <?php echo $contenido; ?>
    </main>

    <footer class="bg-azul-oscuro text-white-50 py-3 mt-auto shadow-sm">
        <div class="container text-center">
            <small>
                <i class="bi bi-shop me-2"></i>
                Sistema de Tienda - Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
            </small>
        </div>
    </footer>

    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Bootstrap 5 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>