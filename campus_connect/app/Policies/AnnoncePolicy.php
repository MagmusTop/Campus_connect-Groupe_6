<?php

namespace App\Policies;

use App\Models\Annonce;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnnoncePolicy
{
    public function before(User $user, $ability)
    {
        // Vérifiez si l'utilisateur est un administrateur
        
        if ($user->isAdmin && !($ability ==='logout')) {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Annonce $annonce): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        $userRole = $user->role->nom;
        $roles = ['administrateur', 'enseignant'];
        return in_array($userRole, $roles)
        ? Response::allow()
        : Response::deny('Vous n\'avez pas la permission de créer une annonce.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Annonce $annonce)
    {
        $userRole = $user->role->nom;
        $roles = ['administrateur'];
        return in_array($userRole, $roles)
        ? Response::allow()
        : Response::deny('Vous n\'avez pas la permission de modifier cette annonce.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Annonce $annonce)
    {
        $userRole = $user->role->nom;
        $roles = ['administrateur'];
        return in_array($userRole, $roles)
        ? Response::allow()
        : Response::deny('Vous n\'avez pas la permission de supprimer cette annonce.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Annonce $annonce): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Annonce $annonce): bool
    {
        return false;
    }
}
