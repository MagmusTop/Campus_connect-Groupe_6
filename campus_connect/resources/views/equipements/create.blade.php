@extends('layouts.app')

@section('content')
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
                                    <label for="materiels_category_id" class="form-label">Catégorie </label>
                                    <div class="dropdown-search">
                                        <input type="text" class="form-control search-input" id="search-input" placeholder="Sélectionnez une catégorie" autocomplete="off">
                                        <span class="dropdown-arrow">▼</span>
                                        <div class="dropdown-list" id="dropdown-list">
                                        <select class="hidden-select form-control dr-my-select" id="materiels_category_id" name="materiels_category_id" required>
                                            @foreach($categories as $categorie)
                                                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantite" class="form-label">Quantité *</label>
                                    <input type="number" class="form-control" id="quantite" name="quantite" min="0" required>
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
<style>
.form-group {
    max-width: 400px;
    margin: 20px auto;
}

.form-label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #333;
}

.dropdown-search {
    position: relative;
    width: 100%;
}

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
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.dropdown-list.show {
    display: block;
}

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

.no-results {
    padding: 10px;
    text-align: center;
    color: #999;
    font-style: italic;
}

/* Cache le select original */
.hidden-select {
    display: none;
}
</style>

<script>
    // Données de catégories (remplacez par vos données PHP)
    let categories = [];
    @foreach($categories as $categorie)
        categories.push({ id: {{ $categorie->id }}, nom: "{{ $categorie->nom }}" });
    @endforeach

    const searchInput = document.getElementById('search-input');
    const dropdownList = document.getElementById('dropdown-list');
    const dropdownArrow = document.querySelector('.dropdown-arrow');
    const hiddenSelect = document.getElementById('materiels_category_id');
    const selectedValue = document.getElementById('selected-value');
    const selectedText = document.getElementById('selected-text');
    const selectedId = document.getElementById('selected-id');

    let selectedCategory = null;

    // Initialiser le select caché avec les options
    function initializeSelect() {
        hiddenSelect.innerHTML = '<option value="">Sélectionnez une catégorie</option>';
        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.nom;
            hiddenSelect.appendChild(option);
        });
    }

    // Afficher les options filtrées
    function renderDropdown(filter = '') {
        const filterLower = filter.toLowerCase();
        const filtered = categories.filter(cat =>
        cat.nom.toLowerCase().includes(filterLower)
        );

        dropdownList.innerHTML = '';

        if (filtered.length === 0 && filter) {
            // Option pour créer une nouvelle catégorie
            const createItem = document.createElement('div');
            createItem.className = 'dropdown-item create-new';
            createItem.innerHTML = `"<strong>${filter}</strong>"`;
            createItem.onclick = () => createNewCategory(filter);
            dropdownList.appendChild(createItem);
        } else if (filtered.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'no-results';
            noResults.textContent = 'Aucune catégorie trouvée';
            dropdownList.appendChild(noResults);
        } else {
            filtered.forEach(cat => {
                const item = document.createElement('div');
                item.className = 'dropdown-item';
            if (selectedCategory && selectedCategory.id === cat.id) {
                item.classList.add('selected');
            }
            item.textContent = cat.nom;
            item.onclick = () => selectCategory(cat);
            dropdownList.appendChild(item);
            });

            // Ajouter l'option de création si du texte est saisi
            if (filter && !filtered.some(cat => cat.nom.toLowerCase() === filterLower)) {
                const createItem = document.createElement('div');
                createItem.className = 'dropdown-item create-new';
                createItem.innerHTML = ` "<strong>${filter}</strong>"`;
                createItem.onclick = () => createNewCategory(filter);
                dropdownList.appendChild(createItem);
            }
        }
    }

    // Sélectionner une catégorie
    function selectCategory(category) {
        selectedCategory = category;
        searchInput.value = category.nom;
        hiddenSelect.value = category.id;
        closeDropdown();

        // Afficher le résultat
        selectedText.textContent = category.nom;
        selectedId.textContent = category.id;
        selectedValue.style.display = 'block';
    }

    // Créer une nouvelle catégorie
    function createNewCategory(nom) {
        const newId = Math.max(...categories.map(c => c.id)) + 1;
        const newCategory = { id: newId, nom: nom };

        categories.push(newCategory);

        // Ajouter l'option au select caché
        const option = document.createElement('option');
        option.value = newCategory.id;
        option.textContent = newCategory.nom;
        hiddenSelect.appendChild(option);

        selectCategory(newCategory);

        alert(`Nouvelle catégorie "${nom}" créée avec l'ID ${newId}`);
    }

    // Ouvrir/fermer le dropdown
    function toggleDropdown() {
        dropdownList.classList.toggle('show');
        dropdownArrow.classList.toggle('open');
    }

    function closeDropdown() {
        dropdownList.classList.remove('show');
        dropdownArrow.classList.remove('open');
    }

    // Événements
    searchInput.addEventListener('focus', () => {
        renderDropdown(searchInput.value);
        dropdownList.classList.add('show');
        dropdownArrow.classList.add('open');
    });

    searchInput.addEventListener('input', (e) => {
        renderDropdown(e.target.value);
        if (!dropdownList.classList.contains('show')) {
            dropdownList.classList.add('show');
            dropdownArrow.classList.add('open');
        }
    });

    searchInput.addEventListener('click', toggleDropdown);

    // Fermer le dropdown en cliquant à l'extérieur
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.dropdown-search')) {
            closeDropdown();
            // Restaurer la valeur sélectionnée si aucune sélection valide
            if (selectedCategory) {
                searchInput.value = selectedCategory.nom;
            } else {
                searchInput.value = '';
            }
        }
    });

    // Initialiser
    initializeSelect();
</script>

@endsection