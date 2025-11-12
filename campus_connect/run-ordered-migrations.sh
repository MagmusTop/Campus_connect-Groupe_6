#!/bin/bash

# Script pour exécuter les migrations Laravel dans un ordre spécifique
# Usage: ./run-ordered-migrations.sh [rollback]

# Couleurs pour l'affichage
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Définir l'ordre des migrations
MIGRATIONS=(
    "create_cache_table"
    "create_jobs_table"
    "create_roles_table"
    "create_users_table"
    "create_etudiants_table"
    "create_enseignants_table"
    "create_administrateurs_table"
    "create_categories_table"
    "create_salles_table"
    "create_equipements_table"
    "create_annonces_table"
    "create_reservations_table"
    "create_reponses_table"
    # Ajoutez vos migrations ici dans l'ordre souhaité
)

# Fonction pour afficher les messages colorés
print_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Fonction pour trouver le fichier de migration
find_migration_file() {
    local migration_name=$1
    local migration_file=$(find database/migrations -name "*_${migration_name}.php" | head -1)
    
    if [[ -z "$migration_file" ]]; then
        print_error "Fichier de migration non trouvé pour: $migration_name"
        return 1
    fi
    
    echo "$migration_file"
    return 0
}

# Fonction pour exécuter une migration
run_migration() {
    local migration_name=$1
    local migration_file=$(find_migration_file "$migration_name")
    
    if [[ $? -ne 0 ]]; then
        return 1
    fi
    
    print_info "Exécution de la migration: $migration_name"
    
    if php artisan migrate --path="$migration_file" --step; then
        print_success "Migration $migration_name exécutée avec succès"
        return 0
    else
        print_error "Erreur lors de l'exécution de $migration_name"
        return 1
    fi
}

# Fonction pour rollback une migration
rollback_migration() {
    local migration_name=$1
    
    print_info "Rollback de la migration: $migration_name"
    
    if php artisan migrate:rollback --step=1; then
        print_success "Rollback $migration_name exécuté avec succès"
        return 0
    else
        print_error "Erreur lors du rollback de $migration_name"
        return 1
    fi
}

# Fonction pour exécuter toutes les migrations dans l'ordre
run_all_migrations() {
    print_info "Début de l'exécution des migrations dans l'ordre défini..."
    
    for migration in "${MIGRATIONS[@]}"; do
        if ! run_migration "$migration"; then
            read -p "Voulez-vous continuer malgré l'erreur ? (y/N): " -n 1 -r
            echo
            if [[ ! $REPLY =~ ^[Yy]$ ]]; then
                print_warning "Arrêt de l'exécution des migrations"
                exit 1
            fi
        fi
        echo "---"
    done
    
    print_success "🎉 Toutes les migrations ont été exécutées avec succès !"
}

# Fonction pour rollback toutes les migrations dans l'ordre inverse
rollback_all_migrations() {
    print_info "Début du rollback des migrations dans l'ordre inverse..."
    
    # Inverser l'ordre du tableau
    for ((i=${#MIGRATIONS[@]}-1; i>=0; i--)); do
        migration="${MIGRATIONS[$i]}"
        if ! rollback_migration "$migration"; then
            read -p "Voulez-vous continuer malgré l'erreur ? (y/N): " -n 1 -r
            echo
            if [[ ! $REPLY =~ ^[Yy]$ ]]; then
                print_warning "Arrêt du rollback des migrations"
                exit 1
            fi
        fi
        echo "---"
    done
    
    print_success "🎉 Tous les rollbacks ont été exécutés avec succès !"
}

# Vérifier si Laravel est disponible
if ! command -v php &> /dev/null || ! php artisan --version &> /dev/null; then
    print_error "Laravel/Artisan n'est pas disponible dans ce répertoire"
    exit 1
fi

# Menu principal
echo "==============================================="
echo "    Script de Migration Laravel Ordonnée"
echo "==============================================="

case "${1:-}" in
    "rollback"|"r")
        rollback_all_migrations
        ;;
    "list"|"l")
        print_info "Ordre des migrations défini:"
        for i in "${!MIGRATIONS[@]}"; do
            echo "$((i+1)). ${MIGRATIONS[$i]}"
        done
        ;;
    "help"|"h"|"-h"|"--help")
        echo "Usage: $0 [OPTION]"
        echo ""
        echo "Options:"
        echo "  (aucune)     Exécuter toutes les migrations dans l'ordre"
        echo "  rollback, r  Rollback toutes les migrations dans l'ordre inverse"
        echo "  list, l      Afficher l'ordre des migrations"
        echo "  help, h      Afficher cette aide"
        ;;
    "")
        run_all_migrations
        ;;
    *)
        print_error "Option inconnue: $1"
        echo "Utilisez '$0 help' pour voir les options disponibles"
        exit 1
        ;;
esac