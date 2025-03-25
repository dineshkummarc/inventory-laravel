<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Sistema de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/css/tabler.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #45247b;
            --primary-light: #6d4a9e;
            --primary-dark: #2e1957;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px;
        }
        
        /* Sidebar rediseñado */
        .navbar-vertical {
            width: var(--sidebar-width);
            position: fixed;
            height: 100vh;
            z-index: 1030;
            transition: all 0.3s ease;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: 5px 0 15px rgba(0,0,0,0.1);
            border-right: none;
        }
        
        /* Logo del sidebar */
        .navbar-brand {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 1rem;
        }
        
        .navbar-brand img {
            transition: all 0.3s ease;
        }
        
        .navbar-brand-text {
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
            margin-left: 10px;
            transition: all 0.3s ease;
        }
        
        /* Elementos del menú */
        .navbar-nav {
            padding: 0 1rem;
        }
        
        .nav-item {
            margin-bottom: 5px;
            border-radius: 6px;
            overflow: hidden;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            border-radius: 6px;
        }
        
        .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white !important;
            transform: translateX(3px);
        }
        
        .nav-link.active {
            background: rgba(255,255,255,0.15);
            color: white !important;
            font-weight: 500;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .nav-link-icon {
            margin-right: 12px;
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .nav-link-title {
            transition: all 0.3s ease;
        }
        
        /* Efecto hover moderno */
        .nav-item:hover .nav-link-icon {
            transform: scale(1.1);
        }
        
        /* Versión móvil (sidebar colapsado) */
        @media (max-width: 991.98px) {
            .navbar-vertical {
                width: var(--sidebar-collapsed-width);
                transform: translateX(0);
            }
            
            .navbar-brand {
                padding: 1rem 0;
                justify-content: center;
            }
            
            .navbar-brand img {
                width: 40px;
                margin-right: 0;
            }
            
            .navbar-brand-text,
            .nav-link-title {
                display: none;
            }
            
            .nav-link {
                justify-content: center;
                padding: 0.75rem 0;
            }
            
            .nav-link-icon {
                margin-right: 0;
                font-size: 1.4rem;
            }
            
            .nav-link:hover {
                transform: translateY(-3px);
            }
        }
        
        /* Contenido principal */
        .page-wrapper {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        @media (max-width: 991.98px) {
            .page-wrapper {
                margin-left: var(--sidebar-collapsed-width);
            }
        }
        
        /* Botón hamburguesa para móviles */
        .mobile-menu-toggle {
            display: none;
            background: var(--primary-color);
            border: none;
            color: white;
            border-radius: 4px;
            padding: 8px 10px;
            margin-right: 10px;
        }
        
        @media (max-width: 991.98px) {
            .mobile-menu-toggle {
                display: block;
            }
        }
        
        /* Efecto de toggle para mostrar/ocultar sidebar en móviles */
        .navbar-vertical.collapsed {
            transform: translateX(calc(-1 * var(--sidebar-collapsed-width)));
        }
        
        .navbar-vertical.collapsed + .page-wrapper {
            margin-left: 0;
        }
        
        /* Estilos adicionales para el contenido */
        .container-fluid {
            padding: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Transiciones suaves */
        * {
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .badge{
            color:#fff!important;
        }
    </style>
</head>
<body class="border-top-wide border-primary d-flex flex-column">

    <!-- Sidebar -->
    <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark" id="sidebar">
        <div class="container-fluid">
            <!-- Logo -->
            <div class="navbar-brand pt-3 pb-2 px-3">
                <a href="{{ url('/') }}" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="{{ asset('logo.png') }}" width="180" height="40" alt="Logo" class="me-2">
                    
                </a>
            </div>
            
            <div class="collapse navbar-collapse show" id="navbar-menu">
                <ul class="navbar-nav pt-2">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <span class="nav-link-icon">
                                <i class="bi bi-speedometer2"></i>
                            </span>
                            <span class="nav-link-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('sales*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                            <span class="nav-link-icon">
                                <i class="bi bi-coin"></i>
                            </span>
                            <span class="nav-link-title">Ventas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <span class="nav-link-icon">
                                <i class="bi bi-box-seam"></i>
                            </span>
                            <span class="nav-link-title">Productos</span>
                        </a>
                    </li>
                    <!-- Ejemplo de ítem adicional -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}"href="{{ route('categories.index') }}">
                            <span class="nav-link-icon">
                                <i class="bi bi-tags"></i>
                            </span>
                            <span class="nav-link-title">Categorías</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reports*') ? 'active' : '' }}" href="#">
                            <span class="nav-link-icon">
                                <i class="bi bi-graph-up"></i>
                            </span>
                            <span class="nav-link-title">Reportes</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </aside>

    <!-- Contenido principal -->
    <main class="page-wrapper" id="mainContent">
        <div class="container-fluid">
            <button class="mobile-menu-toggle d-lg-none" id="mobileMenuToggle">
                <i class="bi bi-list"></i>
            </button>
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0/dist/js/tabler.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        
        if (mobileMenuToggle && sidebar) {
            // Toggle del sidebar en móviles
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
            });
            
            // Cerrar sidebar al hacer clic fuera en móviles
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 991.98 && 
                    !sidebar.contains(event.target) && 
                    !mobileMenuToggle.contains(event.target)) {
                    sidebar.classList.add('collapsed');
                }
            });
            
            // Ajustar el sidebar al cambiar el tamaño de la ventana
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991.98) {
                    sidebar.classList.remove('collapsed');
                }
            });
        }
    });
    </script>
</body>
</html>