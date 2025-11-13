<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::get('/', function () {
    return view('home');
})->name('home');

// Routes pour les annonces
Route::prefix('annonces')->name('annonces.')->group(function () {
    Route::get('/', function () {
        // Données temporaires pour les annonces
        $annonces = collect([
            (object)[
                'id' => 1,
                'title' => 'Session d\'examens de Janvier 2024',
                'content' => 'La session d\'examens de janvier 2024 se déroulera du 15 au 30 janvier. Tous les étudiants sont priés de consulter leur emploi du temps.',
                'user' => (object)['name' => 'Administration'],
                'created_at' => now()->subDays(2),
                'category' => (object)['name' => 'Examens']
            ],
            (object)[
                'id' => 2,
                'title' => 'Atelier de programmation',
                'content' => 'Un atelier de programmation Python sera organisé le 25 décembre. Inscriptions ouvertes jusqu\'au 20 décembre.',
                'user' => (object)['name' => 'Département Informatique'],
                'created_at' => now()->subDays(5),
                'category' => (object)['name' => 'Activités']
            ],
            (object)[
                'id' => 3,
                'title' => 'Maintenance des serveurs',
                'content' => 'Une maintenance des serveurs est prévue ce weekend. Le campus numérique sera inaccessible de samedi 20h à dimanche 8h.',
                'user' => (object)['name' => 'Service Informatique'],
                'created_at' => now()->subDays(1),
                'category' => (object)['name' => 'Maintenance']
            ]
        ]);
        
        return view('annonces.index', compact('annonces'));
    })->name('index');
    
    Route::get('/create', function () {
        return view('annonces.create');
    })->name('create');
    
    Route::get('/{id}', function ($id) {
        // Simulation d'une annonce spécifique
        $annonce = (object)[
            'id' => $id,
            'title' => 'Session d\'examens de Janvier 2024',
            'content' => "La session d'examens de janvier 2024 se déroulera du 15 au 30 janvier. Tous les étudiants sont priés de consulter leur emploi du temps.\n\nLes salles seront attribuées comme suit :\n- Bâtiment A : Licences\n- Bâtiment B : Masters\n- Bâtiment C : Doctorats\n\nEn cas d'empêchement, contacter immédiatement le service des examens.",
            'user' => (object)['name' => 'Administration'],
            'created_at' => now()->subDays(2),
            'category' => (object)['name' => 'Examens']
        ];
        return view('annonces.show', compact('annonce'));
    })->name('show');
    
    Route::get('/{id}/edit', function ($id) {
        // Simulation d'une annonce pour l'édition
        $annonce = (object)[
            'id' => $id,
            'title' => 'Session d\'examens de Janvier 2024',
            'content' => "La session d'examens de janvier 2024 se déroulera du 15 au 30 janvier. Tous les étudiants sont priés de consulter leur emploi du temps.",
            'category' => (object)['name' => 'Examens']
        ];
        return view('annonces.edit', compact('annonce'));
    })->name('edit');
    
    // Routes POST temporairement désactivées avec message
    Route::post('/', function () {
        return redirect()->route('annonces.index')
            ->with('info', 'Fonctionnalité de création d\'annonce en développement');
    })->name('store');
    
    Route::put('/{id}', function ($id) {
        return redirect()->route('annonces.show', $id)
            ->with('info', 'Fonctionnalité de modification d\'annonce en développement');
    })->name('update');
    
    Route::delete('/{id}', function ($id) {
        return redirect()->route('annonces.index')
            ->with('success', 'Annonce supprimée avec succès! (Fonctionnalité en développement)');
    })->name('destroy');
});

// Routes pour les réservations
Route::prefix('reservations')->name('reservations.')->group(function () {
    Route::get('/', function () {
        // Données temporaires pour les réservations
        $reservations = collect([
            (object)[
                'id' => 1,
                'statut' => 'validée',
                'user' => (object)['name' => 'Vous'],
                'date_debut' => now()->addDays(1)->setHour(9),
                'date_fin' => now()->addDays(1)->setHour(12),
                'motif' => 'Cours de programmation avancée',
                'salle' => (object)['nom' => 'Amphithéâtre A1'],
                'equipement' => null
            ],
            (object)[
                'id' => 2,
                'statut' => 'en_attente',
                'user' => (object)['name' => 'Vous'],
                'date_debut' => now()->addDays(3)->setHour(14),
                'date_fin' => now()->addDays(3)->setHour(16),
                'motif' => 'Réunion de projet',
                'salle' => (object)['nom' => 'Salle B203'],
                'equipement' => null
            ],
            (object)[
                'id' => 3,
                'statut' => 'rejetée',
                'user' => (object)['name' => 'Vous'],
                'date_debut' => now()->subDays(2)->setHour(10),
                'date_fin' => now()->subDays(2)->setHour(12),
                'motif' => 'Utilisation personnelle',
                'salle' => null,
                'equipement' => (object)['nom' => 'Vidéoprojecteur HD']
            ]
        ]);
        
        return view('reservations.index', compact('reservations'));
    })->name('index');
    
    Route::get('/create', function () {
        // Données temporaires pour le formulaire
        $salles = collect([
            (object)['id' => 1, 'nom' => 'Amphithéâtre A1', 'localisation' => 'Bâtiment Principal', 'capacite' => 120],
            (object)['id' => 2, 'nom' => 'Salle B203', 'localisation' => 'Bâtiment B', 'capacite' => 30],
            (object)['id' => 3, 'nom' => 'Labo Informatique C101', 'localisation' => 'Bâtiment C', 'capacite' => 25]
        ]);
        
        $materiels = collect([
            (object)['id' => 1, 'nom' => 'Vidéoprojecteur HD', 'quantite' => 8],
            (object)['id' => 2, 'nom' => 'Ordinateur Portable', 'quantite' => 15],
            (object)['id' => 3, 'nom' => 'Tablette Graphique', 'quantite' => 5]
        ]);
        
        return view('reservations.create', compact('salles', 'materiels'));
    })->name('create');
    
    Route::get('/{id}', function ($id) {
        // Simulation d'une réservation spécifique
        $reservation = (object)[
            'id' => $id,
            'statut' => 'validée',
            'user' => (object)['name' => 'Vous'],
            'date_debut' => now()->addDays(1)->setHour(9),
            'date_fin' => now()->addDays(1)->setHour(12),
            'motif' => 'Cours de programmation avancée pour les étudiants en Master 2. Le cours portera sur les architectures microservices et les patterns de conception avancés.',
            'salle' => (object)[
                'nom' => 'Amphithéâtre A1',
                'capacite' => 120,
                'localisation' => 'Bâtiment Principal',
                'description' => 'Amphithéâtre équipé de vidéoprojecteur HD et sonorisation'
            ],
            'equipement' => null
        ];
        return view('reservations.show', compact('reservation'));
    })->name('show');
    
    Route::get('/{id}/edit', function ($id) {
        // Simulation d'une réservation pour l'édition
        $reservation = (object)[
            'id' => $id,
            'motif' => 'Cours de programmation avancée',
            'date_debut' => now()->addDays(1)->setHour(9),
            'date_fin' => now()->addDays(1)->setHour(12),
            'statut' => 'validée',
            'salle_id' => 1,
            'equipement_id' => null
        ];
        
        $salles = collect([
            (object)['id' => 1, 'nom' => 'Amphithéâtre A1', 'localisation' => 'Bâtiment Principal', 'capacite' => 120],
            (object)['id' => 2, 'nom' => 'Salle B203', 'localisation' => 'Bâtiment B', 'capacite' => 30]
        ]);
        
        $materiels = collect([
            (object)['id' => 1, 'nom' => 'Vidéoprojecteur HD', 'quantite' => 8],
            (object)['id' => 2, 'nom' => 'Ordinateur Portable', 'quantite' => 15]
        ]);
        
        return view('reservations.edit', compact('reservation', 'salles', 'materiels'));
    })->name('edit');
    
    // Routes POST/PUT/DELETE temporaires
    Route::post('/', function () {
        return redirect()->route('reservations.index')
            ->with('success', 'Réservation créée avec succès! (Fonctionnalité en développement)');
    })->name('store');
    
    Route::put('/{id}', function ($id) {
        return redirect()->route('reservations.show', $id)
            ->with('success', 'Réservation modifiée avec succès! (Fonctionnalité en développement)');
    })->name('update');
    
    Route::delete('/{id}', function ($id) {
        return redirect()->route('reservations.index')
            ->with('success', 'Réservation annulée avec succès! (Fonctionnalité en développement)');
    })->name('destroy');
});

// Routes pour les salles
Route::prefix('salles')->name('salles.')->group(function () {
    Route::get('/', function () {
        // Données temporaires pour les salles
        $salles = collect([
            (object)[
                'id' => 1,
                'nom' => 'Amphithéâtre A1',
                'capacite' => 120,
                'localisation' => 'Bâtiment Principal',
                'description' => 'Amphithéâtre équipé de vidéoprojecteur et sonorisation'
            ],
            (object)[
                'id' => 2,
                'nom' => 'Salle B203',
                'capacite' => 30,
                'localisation' => 'Bâtiment B',
                'description' => 'Salle de cours standard'
            ],
            (object)[
                'id' => 3,
                'nom' => 'Labo Informatique C101',
                'capacite' => 25,
                'localisation' => 'Bâtiment C',
                'description' => 'Laboratoire équipé de 25 postes informatiques'
            ]
        ]);
        
        return view('salles.index', compact('salles'));
    })->name('index');
    
    Route::get('/create', function () {
        return view('salles.create');
    })->name('create');
    
    Route::get('/{id}', function ($id) {
        // Simulation d'une salle spécifique avec réservations
        $salle = (object)[
            'id' => $id,
            'nom' => 'Amphithéâtre A1',
            'capacite' => 120,
            'localisation' => 'Bâtiment Principal',
            'description' => 'Amphithéâtre équipé de vidéoprojecteur HD, système de sonorisation et climatisation. Connexion Ethernet et Wi-Fi disponible.',
            'reservations' => collect([
                (object)[
                    'id' => 1,
                    'date_debut' => now()->addDays(1)->setHour(9),
                    'date_fin' => now()->addDays(1)->setHour(12),
                    'statut' => 'validée',
                    'user' => (object)['name' => 'Dr. Martin'],
                    'motif' => 'Cours de programmation avancée'
                ],
                (object)[
                    'id' => 2,
                    'date_debut' => now()->addDays(2)->setHour(14),
                    'date_fin' => now()->addDays(2)->setHour(17),
                    'statut' => 'en_attente',
                    'user' => (object)['name' => 'Prof. Dubois'],
                    'motif' => 'Séminaire de recherche'
                ]
            ])
        ];
        return view('salles.show', compact('salle'));
    })->name('show');
    
    Route::get('/{id}/edit', function ($id) {
        // Simulation d'une salle pour l'édition
        $salle = (object)[
            'id' => $id,
            'nom' => 'Amphithéâtre A1',
            'capacite' => 120,
            'localisation' => 'Bâtiment Principal',
            'description' => 'Amphithéâtre équipé de vidéoprojecteur et sonorisation'
        ];
        return view('salles.edit', compact('salle'));
    })->name('edit');
    
    // Routes POST/PUT/DELETE temporaires
    Route::post('/', function () {
        return redirect()->route('salles.index')
            ->with('success', 'Salle créée avec succès! (Fonctionnalité en développement)');
    })->name('store');
    
    Route::put('/{id}', function ($id) {
        return redirect()->route('salles.show', $id)
            ->with('success', 'Salle modifiée avec succès! (Fonctionnalité en développement)');
    })->name('update');
    
    Route::delete('/{id}', function ($id) {
        return redirect()->route('salles.index')
            ->with('success', 'Salle supprimée avec succès! (Fonctionnalité en développement)');
    })->name('destroy');
});

// Routes pour le matériel
Route::prefix('materiel')->name('materiel.')->group(function () {
    Route::get('/', function () {
        // Données temporaires pour le matériel
        $materiels = collect([
            (object)[
                'id' => 1,
                'nom' => 'Vidéoprojecteur HD',
                'quantite' => 8,
                'description' => 'Vidéoprojecteur haute définition 1080p avec entrées HDMI et VGA',
                'categorie' => (object)['name' => 'Audiovisuel'],
                'reservations' => collect()
            ],
            (object)[
                'id' => 2,
                'nom' => 'Ordinateur Portable',
                'quantite' => 15,
                'description' => 'PC Portable Dell Latitude pour présentations et travaux pratiques',
                'categorie' => (object)['name' => 'Informatique'],
                'reservations' => collect()
            ],
            (object)[
                'id' => 3,
                'nom' => 'Tablette Graphique',
                'quantite' => 5,
                'description' => 'Tablettes Wacom Intuos pour cours de design et infographie',
                'categorie' => (object)['name' => 'Informatique'],
                'reservations' => collect()
            ]
        ]);
        
        return view('materiel.index', compact('materiels'));
    })->name('index');
    
    Route::get('/create', function () {
        // Données temporaires pour les catégories
        $categories = collect([
            (object)['id' => 1, 'nom' => 'Audiovisuel'],
            (object)['id' => 2, 'nom' => 'Informatique'],
            (object)['id' => 3, 'nom' => 'Mobilier'],
            (object)['id' => 4, 'nom' => 'Réseau']
        ]);
        
        return view('materiel.create', compact('categories'));
    })->name('create');
    
    Route::get('/{id}', function ($id) {
        // Simulation d'un matériel spécifique avec réservations
        $materiel = (object)[
            'id' => $id,
            'nom' => 'Vidéoprojecteur HD',
            'quantite' => 8,
            'description' => 'Vidéoprojecteur haute définition 1080p avec entrées HDMI et VGA. Lumens: 3500, Résolution: 1920x1080. Compatible avec tous les systèmes d\'exploitation.',
            'categorie' => (object)['name' => 'Audiovisuel'],
            'reservations' => collect([
                (object)[
                    'id' => 1,
                    'date_debut' => now()->addDays(1)->setHour(9),
                    'date_fin' => now()->addDays(1)->setHour(12),
                    'statut' => 'validée',
                    'user' => (object)['name' => 'Dr. Martin'],
                    'motif' => 'Présentation conférence'
                ]
            ])
        ];
        return view('materiel.show', compact('materiel'));
    })->name('show');
    
    Route::get('/{id}/edit', function ($id) {
        // Simulation d'un matériel pour l'édition
        $materiel = (object)[
            'id' => $id,
            'nom' => 'Vidéoprojecteur HD',
            'quantite' => 8,
            'description' => 'Vidéoprojecteur haute définition 1080p avec entrées HDMI et VGA',
            'materiels_category_id' => 1
        ];
        
        $categories = collect([
            (object)['id' => 1, 'nom' => 'Audiovisuel'],
            (object)['id' => 2, 'nom' => 'Informatique'],
            (object)['id' => 3, 'nom' => 'Mobilier']
        ]);
        
        return view('materiel.edit', compact('materiel', 'categories'));
    })->name('edit');
    
    // Routes POST/PUT/DELETE temporaires
    Route::post('/', function () {
        return redirect()->route('materiel.index')
            ->with('success', 'Matériel créé avec succès! (Fonctionnalité en développement)');
    })->name('store');
    
    Route::put('/{id}', function ($id) {
        return redirect()->route('materiel.show', $id)
            ->with('success', 'Matériel modifié avec succès! (Fonctionnalité en développement)');
    })->name('update');
    
    Route::delete('/{id}', function ($id) {
        return redirect()->route('materiel.index')
            ->with('success', 'Matériel supprimé avec succès! (Fonctionnalité en développement)');
    })->name('destroy');
});

// Routes pour l'administration (validation des réservations)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/reservations', function () {
        // Toutes les réservations en attente pour l'admin
        $reservations = collect([
            (object)[
                'id' => 1,
                'statut' => 'en_attente',
                'user' => (object)['name' => 'Dr. Martin'],
                'date_debut' => now()->addDays(1)->setHour(9),
                'date_fin' => now()->addDays(1)->setHour(12),
                'motif' => 'Cours de programmation avancée',
                'salle' => (object)['nom' => 'Amphithéâtre A1'],
                'equipement' => null
            ],
            (object)[
                'id' => 2,
                'statut' => 'en_attente',
                'user' => (object)['name' => 'Prof. Dubois'],
                'date_debut' => now()->addDays(2)->setHour(14),
                'date_fin' => now()->addDays(2)->setHour(17),
                'motif' => 'Séminaire de recherche',
                'salle' => null,
                'equipement' => (object)['nom' => 'Vidéoprojecteur HD']
            ]
        ]);
        
        return view('reservations.index', compact('reservations'));
    })->name('reservations.index');
    
    Route::post('/reservations/{id}/validate', function ($id) {
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation validée avec succès! (Fonctionnalité en développement)');
    })->name('reservations.validate');
    
    Route::post('/reservations/{id}/reject', function ($id) {
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation rejetée avec succès! (Fonctionnalité en développement)');
    })->name('reservations.reject');
    
    Route::get('/annonces', function () {
        // Toutes les annonces pour l'admin (avec actions)
        $annonces = collect([
            (object)[
                'id' => 1,
                'title' => 'Session d\'examens de Janvier 2024',
                'content' => 'La session d\'examens de janvier 2024 se déroulera du 15 au 30 janvier.',
                'user' => (object)['name' => 'Administration'],
                'created_at' => now()->subDays(2),
                'category' => (object)['name' => 'Examens']
            ],
            (object)[
                'id' => 2,
                'title' => 'Atelier de programmation',
                'content' => 'Un atelier de programmation Python sera organisé le 25 décembre.',
                'user' => (object)['name' => 'Département Informatique'],
                'created_at' => now()->subDays(5),
                'category' => (object)['name' => 'Activités']
            ]
        ]);
        
        return view('annonces.index', compact('annonces'));
    })->name('annonces.index');
});

// Routes d'authentification (temporaires)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', function () {
    return redirect('/')->with('info', 'Page de connexion en développement');
})->name('login');

Route::get('/register', function () {
    return redirect('/')->with('info', 'Page d\'inscription en développement');
})->name('register');

// Routes de fallback (doivent être en dernier)
Route::get('/{id}', function ($id) {
    // Redirection vers les annonces pour les URLs non reconnues
    return redirect()->route('annonces.show', $id);
});

Route::get('/{id}/edit', function ($id) {
    // Redirection vers l'édition d'annonce pour les URLs non reconnues
    return redirect()->route('annonces.edit', $id);
});

// Assurez-vous que cette route existe
Route::get('/salles/create', function () {
    return view('salles.create');
})->name('salles.create');

// Et cette route POST pour traiter le formulaire
Route::post('/salles', function () {
    return redirect()->route('salles.index')
        ->with('success', 'Salle créée avec succès!');
})->name('salles.store');