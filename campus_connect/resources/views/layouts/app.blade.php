<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusConnect - {{ $title ?? 'Portail Universitaire' }}</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Votre CSS personnalisé -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">



   @vite(['resources/css/app.css', 'resources/js/app.js'])


</head>
<body>
    @include('partials.navbar')

    <main>
        @include('partials.messages')
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateThemeIcon() {
            const icon = document.querySelector('.theme-toggle i');
            const theme = document.documentElement.getAttribute('data-bs-theme');
            if (theme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        function toggleTheme() {
            const html = document.documentElement;
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateThemeIcon();
        }

        document.documentElement.setAttribute('data-bs-theme', localStorage.getItem('theme') || 'light');
        updateThemeIcon();
    </script>
    @stack('scripts')
</body>
</html>