<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido | Sistema</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <style>
        :root {
            --primary-color: #45247b;
            --primary-light: #6d4a9e;
            --primary-dark: #2e1957;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 80px;
        }
        
        body {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 440px;
            text-align: center;
        }
        
        .welcome-logo {
            width: 180px;
            margin-bottom: 2rem;
        }
        
        .btn-primary-custom {
            background: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            width: 100%;
            margin: 0.5rem 0;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
        }
        
        .auth-links {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .welcome-title {
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            font-size: 2.2rem;
            font-weight: 600;
        }
        
        @media (max-width: 576px) {
            .welcome-card {
                padding: 1.5rem;
            }
            
            .welcome-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="welcome-card">
        <!-- Cambia la ruta de tu logo -->
        <img src="{{ asset('logomorado.png') }}" alt="Logo" class="welcome-logo">
        
        <h1 class="welcome-title">Bienvenido al Sistema</h1>
        
        @guest
        <div class="auth-links">
            <a href="{{ route('login') }}" class="btn btn-primary-custom d-inline-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-login" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                    <path d="M20 12h-13l3 -3m0 6l-3 -3" />
                </svg>
                <span class="ms-2">Iniciar Sesión</span>
            </a>
            
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-primary-custom d-inline-flex align-items-center justify-content-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                    <path d="M16 19h6" />
                    <path d="M19 16v6" />
                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                </svg>
                <span class="ms-2">Registrarse</span>
            </a>
            @endif
        </div>
        @endguest
    </div>

    <!-- Tabler Icons -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/icons-react/dist/index.umd.min.js"></script>
</body>
</html>