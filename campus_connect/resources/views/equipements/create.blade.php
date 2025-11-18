@extends('layouts.app')

@section('content')

<style>
/* Container */
.dropdown-search {
    position: relative;
    width: 100%;
}

/* Input */
.search-input {
    width: 100%;
    padding: 10px 35px 10px 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
    cursor: pointer;
}
.search-input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

/* Arrow */
.dropdown-arrow {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #666;
    transition: transform 0.3s;
}
.dropdown-arrow.open {
    transform: translateY(-50%) rotate(180deg);
}

/* List */
.dropdown-list {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    border: 1px solid #ccc;
    border-top: none;
    border-radius: 0 0 4px 4px;
    max-height: 250px;
    overflow-y: auto;
    display: none;
    z-index: 1000;
    background-color: #212529;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.dropdown-list.show {
    display: block;
}

/* Items */
.dropdown-item {
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.2s;
}
.dropdown-item:hover {
    background-color: #2067d1ff;
    color: #78adfcff;
}
.dropdown-item.selected {
    background-color: #78adfcff;
    color: #007bff;
}
.dropdown-item.create-new {
    background-color: #f0f8ff;
    color: #007bff;
    font-weight: bold;
    border-top: 2px solid #007bff;
}
.dropdown-item.create-new:hover {
    background-color: #e0f0ff;
}

/* No results */
.no-results {
    padding: 10px;
    text-align: center;
    color: #999;
    font-style: italic;
}

/* Hidden select sent to server */
.hidden-select {
    display: none;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Ajouter du matériel</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('equipements.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nom" class="form-label">Nom du matériel *</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="categorie_id" class="form-label">Catégorie *</label>
                                    <div class="dropdown-search">
                                        <input type="text" class="form-control search-input" id="search-input" placeholder="Sélectionnez une catégorie" autocomplete="off">
                                        <span class="dropdown-arrow">▼</span>

                                        <!-- Liste rendue dynamiquement -->
                                        <div class="dropdown-list" id="dropdown-list"></div>
                                        <!-- Select caché (valeur envoyée au serveur) -->
                                        <select class="hidden-select form-control dr-my-select" id="categorie_id" name="categorie" required>
                                            <option value="">Sélectionnez une catégorie</option>
                                        </select>
                                        

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantite" class="form-label">Quantité *</label>
                                    <input type="number" class="form-control" id="quantite" name="quantite" min="0" default="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('equipements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Créer le matériel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Précharger les catégories depuis Blade
    let categories = [];
    @foreach($categories as $categorie)
        categories.push({ id: {{ $categorie->id }}, nom: @json($categorie->nom) });
    @endforeach

    const searchInput   = document.getElementById('search-input');
    const dropdownList  = document.getElementById('dropdown-list');
    const dropdownArrow = document.querySelector('.dropdown-arrow');
    const hiddenSelect  = document.getElementById('categorie_id');

    let selectedCategory = null;

    // Init du select caché
    function initializeSelect() {
        hiddenSelect.innerHTML = '<option value="">Sélectionnez une catégorie</option>';
        for (const cat of categories) {
            const option = document.createElement('option');
            option.value = String(cat.id);
            option.textContent = cat.nom;
            hiddenSelect.appendChild(option);
        }
    }

    // Rendu de la liste filtrée
    function renderDropdown(filter = '') {
        const filterLower = filter.trim().toLowerCase();
        const filtered = categories.filter(c => c.nom.toLowerCase().includes(filterLower));

        dropdownList.innerHTML = '';

        if (filtered.length === 0 && filterLower) {
            const createItem = document.createElement('div');
            createItem.className = 'dropdown-item create-new';
            createItem.innerHTML = ` <strong>${escapeHtml(filter)}</strong>`;
            createItem.onclick = () => createNewCategory(filter.trim());
            dropdownList.appendChild(createItem);
            return;
        }

        if (filtered.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'no-results';
            noResults.textContent = 'Aucune catégorie trouvée';
            dropdownList.appendChild(noResults);
            return;
        }

        for (const cat of filtered) {
            const item = document.createElement('div');
            item.className = 'dropdown-item';
            if (selectedCategory && selectedCategory.id === cat.id) item.classList.add('selected');
            item.textContent = cat.nom;
            item.onclick = () => selectCategory(cat);
            dropdownList.appendChild(item);
        }

        // Proposer création si saisie ne correspond pas exactement
        if (filterLower && !filtered.some(c => c.nom.toLowerCase() === filterLower)) {
            const createItem = document.createElement('div');
            createItem.className = 'dropdown-item create-new';
            createItem.innerHTML = ` <strong>${escapeHtml(filter)}</strong>`;
            createItem.onclick = () => createNewCategory(filter.trim());
            dropdownList.appendChild(createItem);
        }
    }

    // Sélection d'une catégorie existante
// Sélection d'une catégorie : si useNameAsValue true -> hiddenSelect.value = nom
function selectCategory(category, useNameAsValue = false) {
    selectedCategory = category;
    searchInput.value = category.nom;

    if (useNameAsValue) {
        hiddenSelect.value = category.nom;
    } else {
        hiddenSelect.value = category.id ? String(category.id) : category.nom;
    }

    closeDropdown();
}

    // Création d'une catégorie côté serveur, puis sélection
// Ajoute une nouvelle option locale dont value = nom et sélectionne cette option
function createNewCategoryLocal(nom) {
    const returnedName = nom.trim();
    if (!returnedName) return;

    // Vérifier si une option avec cette valeur existe déjà
    const existingOption = Array.from(hiddenSelect.options).find(o => o.value.toLowerCase() === returnedName.toLowerCase());
    if (!existingOption) {
        const option = document.createElement('option');
        option.value = returnedName; // valeur = nom (string)
        option.textContent = returnedName;
        option.dataset.created = '1';
        hiddenSelect.appendChild(option);
    }

    // Mettre à jour le cache client (facultatif)
    const alreadyCached = categories.some(c => c.nom.toLowerCase() === returnedName.toLowerCase());
    if (!alreadyCached) {
        categories.push({ id: null, nom: returnedName });
    }

    // Sélectionner la catégorie (useNameAsValue = true)
    const category = { id: null, nom: returnedName };
    selectCategory(category, true);
}
    // Toggle du dropdown
    function toggleDropdown() {
        dropdownList.classList.toggle('show');
        dropdownArrow.classList.toggle('open');
        if (dropdownList.classList.contains('show')) renderDropdown(searchInput.value);
    }
    function openDropdown() {
        dropdownList.classList.add('show');
        dropdownArrow.classList.add('open');
    }
    function closeDropdown() {
        dropdownList.classList.remove('show');
        dropdownArrow.classList.remove('open');
    }

    // Sécurité: échapper le HTML inséré
    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }

    // Événements
    searchInput.addEventListener('focus', () => {
        renderDropdown(searchInput.value);
        openDropdown();
    });

    searchInput.addEventListener('input', (e) => {
        renderDropdown(e.target.value);
        if (!dropdownList.classList.contains('show')) openDropdown();
        // Si l'utilisateur modifie le texte, on invalide la sélection actuelle
        hiddenSelect.value = '';
        selectedCategory = null;
    });

    searchInput.addEventListener('click', toggleDropdown);

    // Valider Enter: si un item exact existe, sélectionner; sinon proposer création
// Gestion de la touche Enter : si exact trouvé -> sélectionner ; sinon créer localement
searchInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        const val = searchInput.value.trim();
        if (!val) return;

        const exact = categories.find(c => c.nom.toLowerCase() === val.toLowerCase());
        if (exact) selectCategory(exact, false);
        else createNewCategoryLocal(val);
    }
});

    // Fermer en cliquant à l'extérieur
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown-search')) {
            closeDropdown();
            if (!selectedCategory) searchInput.value = '';
        }
    });

    // Init
    initializeSelect();
</script>

@endsection
