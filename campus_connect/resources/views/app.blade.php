<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusConnect - {{ $title ?? 'Portail Universitaire' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --chatgpt-primary: #10a37f;
            --chatgpt-primary-dark: #0d8c6c;
            --chatgpt-bg: #ffffff;
            --chatgpt-surface: #f7f7f8;
            --chatgpt-border: #e5e5e5;
            --chatgpt-text: #374151;
        }

        [data-bs-theme="dark"] {
            --chatgpt-bg: #343541;
            --chatgpt-surface: #40414f;
            --chatgpt-border: #565869;
            --chatgpt-text: #ececf1;
        }

        body {
            background-color: var(--chatgpt-bg);
            color: var(--chatgpt-text);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--chatgpt-primary) 0%, var(--chatgpt-primary-dark) 100%) !important;
            border-bottom: 1px solid var(--chatgpt-border);
        }

        .sidebar {
            background-color: var(--chatgpt-surface);
            border-right: 1px solid var(--chatgpt-border);
        }

        .card {
            background-color: var(--chatgpt-surface);
            border: 1px solid var(--chatgpt-border);
            border-radius: 12px;
            transition: all 0.2s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--chatgpt-primary) 0%, var(--chatgpt-primary-dark) 100%);
            border: none;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--chatgpt-primary-dark) 0%, #0b755a 100%);
            transform: translateY(-1px);
        }

        .form-control, .form-select {
            background-color: var(--chatgpt-bg);
            border: 1px solid var(--chatgpt-border);
            color: var(--chatgpt-text);
            border-radius: 8px;
        }

        .nav-link {
            color: var(--chatgpt-text) !important;
            border-radius: 8px;
            margin: 2px 0;
            font-weight: 500;
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--chatgpt-primary);
            color: white !important;
        }

        .badge {
            border-radius: 6px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    @include('partials.navbar')
    
    <div class="container-fluid">
        <div class="row">
            @auth
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar" style="min-height: calc(100vh - 72px);">
                <div class="position-sticky pt-3">
                    @include('partials.sidebar')
                </div>
            </nav>
            @endauth
            
            <!-- Main content -->
            <main class="@auth col-md-9 ms-sm-auto col-lg-10 @else col-12 @endauth px-md-4 py-4">
                @include('partials.messages')
                @yield('content')
            </main>
        </div>
    </div>

    @include('partials.footer')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme switcher simple
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        }

        // Charger le theme sauvegardé
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
    </script>
    @stack('scripts')
</body>
</html>