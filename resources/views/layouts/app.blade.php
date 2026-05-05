<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titre') - Gestion Étudiants</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-width: 260px;
            --primary-color: #4f46e5;
            --primary-light: #eef2ff;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: white;
            border-right: 1px solid #e2e8f0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 24px;
            border-bottom: 1px solid #f1f5f9;
        }

        .sidebar-content {
            flex: 1;
            padding: 20px 14px;
            overflow-y: auto;
        }

        .nav-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 700;
            color: #94a3b8;
            margin-bottom: 12px;
            margin-left: 10px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #64748b;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 4px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .sidebar-link i {
            font-size: 1.2rem;
            margin-right: 12px;
        }

        .sidebar-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .sidebar-link.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #f1f5f9;
            background-color: #f8fafc;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding: 40px;
            transition: all 0.3s ease;
        }

        .user-profile-sm {
            display: flex;
            align-items: center;
            padding: 10px;
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-wrapper { margin-left: 0; padding: 20px; }
            .sidebar-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            .sidebar-overlay.active { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a class="text-decoration-none d-flex align-items-center" href="/">
                <div class="bg-primary text-white rounded-3 p-2 me-2">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <span class="fw-bold fs-5 text-dark">UPF Portal</span>
            </a>
        </div>

        <div class="sidebar-content">
            <div class="nav-label">Menu Principal</div>
            <a href="/" class="sidebar-link {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-house-door"></i> Accueil
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                <div class="nav-label mt-4">Administration</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.users-list') }}" class="sidebar-link {{ request()->is('admin/users-list') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Comptes Utilisateurs
                </a>
                @endif

                @if(Auth::user()->isAdmin() || Auth::user()->isProfessor())
                <div class="nav-label mt-4">Gestion Académique</div>
                <a href="/etudiants" class="sidebar-link {{ request()->is('etudiants*') ? 'active' : '' }}">
                    <i class="bi bi-person-workspace"></i> Étudiants
                </a>
                <a href="#" class="sidebar-link">
                    <i class="bi bi-journal-check"></i> Modules & Notes
                </a>
                <a href="#" class="sidebar-link">
                    <i class="bi bi-file-earmark-pdf"></i> Supports de Cours
                </a>
                @endif

                @if(Auth::user()->isStudent())
                <div class="nav-label mt-4">Espace Étudiant</div>
                <a href="/etudiants" class="sidebar-link {{ request()->is('etudiants*') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill"></i> Mon Profil
                </a>
                <a href="#" class="sidebar-link">
                    <i class="bi bi-award"></i> Mes Résultats
                </a>
                <a href="#" class="sidebar-link">
                    <i class="bi bi-calendar-event"></i> Emploi du Temps
                </a>
                <a href="#" class="sidebar-link">
                    <i class="bi bi-chat-dots"></i> Classroom
                </a>
                @endif
            @endauth
        </div>

        @auth
        <div class="sidebar-footer">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle p-2 me-2">
                    <i class="bi bi-person"></i>
                </div>
                <div class="overflow-hidden">
                    <div class="fw-bold text-dark text-truncate small">{{ Auth::user()->name }}</div>
                    <div class="text-muted" style="font-size: 0.7rem;">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                    <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                </button>
            </form>
        </div>
        @else
        <div class="sidebar-footer">
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm w-100 mb-2">Connexion</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm w-100">Inscription</a>
        </div>
        @endauth
    </aside>

    <div class="main-wrapper">
        <!-- Mobile Toggle -->
        <button class="btn btn-light d-lg-none mb-3 shadow-sm" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 bg-success bg-opacity-10 text-success mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 bg-danger bg-opacity-10 text-danger mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('contenu')
    </div>

    <footer class="text-center py-5 text-muted small">
        &copy; {{ date('Y') }} - UPF Student Portal - v2.0
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggle = document.getElementById('sidebarToggle');

        if(toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });
        }

        if(overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
