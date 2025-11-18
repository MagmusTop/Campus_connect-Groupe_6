<nav class="navbar">
    <a class="navbar-brand" href="{{ route('welcome') }}">
        <i class="fa-solid fa-graduation-cap me-2"></i>CampusConnect
    </a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                <i class="fa-solid fa-house"></i> Accueil
            </a>
        </li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="fa-solid fa-book"></i> Formations</a></li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('annonces.*') ? 'active' : '' }}" href="{{ route('annonces.index') }}">
                <i class="fa-solid fa-bullhorn"></i> Annonces
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('reservations.*') ? 'active' : '' }}" href="{{ route('reservations.index') }}">
                <i class="fa-solid fa-ticket"></i> Réservation
            </a>
        </li>

        <li class="nav-item">
            <button class="theme-toggle" onclick="toggleTheme()">
                <i class="fa-solid fa-moon"></i>
            </button>
        </li>
        
        <!-- Menu profil avec survol -->
        <li class="nav-item profile-container">
            <div class="profile-trigger">
                <i class="fa-solid fa-user-circle fa-lg"></i>
                <div class="logout-option">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-link" >
                        <i class="fa-solid fa-right-from-bracket me-2"></i>Déconnexion
                    </button>
                    <a href="#" >
                    </a>
                </form>
                </div>
            </div>
        </li>
    </ul>
</nav>

<style>
    /* Container du profil */
    .profile-container {
        position: relative;
        list-style: none;
    }

    /* Trigger du profil */
    .profile-trigger {
        border: none;
        background: transparent;
        padding: 0.5rem;
        border-radius: 50%;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        position: relative;
    }

    .profile-trigger:hover {
        background: var(--hover-light);
    }

    [data-bs-theme="dark"] .profile-trigger:hover {
        background: var(--hover-dark);
    }

    /* Option déconnexion qui apparaît au survol */
    .logout-option {
        position: absolute;
        top: 100%;
        right: 0;
        background: var(--sidebar);
        border: 1px solid var(--border);
        backdrop-filter: var(--blur-bg);
        border-radius: 8px;
        padding: 0.5rem;
        min-width: 160px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        z-index: 1001;
    }

    .profile-trigger:hover .logout-option {
        opacity: 1;
        visibility: visible;
        transform: translateY(5px);
    }

    .logout-link {
        color: #dc3545;
        text-decoration: none;
        display: flex;
        align-items: center;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .logout-link:hover {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    /* Icône utilisateur */
    .fa-user-circle {
        color: var(--text);
        transition: color 0.3s ease;
        font-size: 1.3rem;
    }

    .profile-trigger:hover .fa-user-circle {
        color: var(--primary);
    }

    /* Supprime tous les traits de survol pour le profil */
    .profile-trigger::after {
        display: none !important;
    }

    /* Styles pour les autres liens de navigation */
    .nav-link:not(.profile-trigger) {
        position: relative;
    }

    .nav-link:not(.profile-trigger)::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0%;
        height: 2px;
        background-color: var(--primary);
        transition: width 0.3s ease, opacity 0.3s ease;
        opacity: 0;
    }

    .nav-link:not(.profile-trigger):hover::after,
    .nav-link:not(.profile-trigger).active::after {
        width: 100%;
        opacity: 1;
    }
</style>