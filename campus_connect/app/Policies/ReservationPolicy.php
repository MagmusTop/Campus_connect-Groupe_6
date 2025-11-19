<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReservationPolicy
{
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
    public function view(User $user, Reservation $reservation): bool
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
        : Response::deny('Vous n\'avez pas la permission de créer une réservation.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Reservation $reservation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reservation $reservation)
    {
        $userRole = $user->role->nom;
        $roles = ['administrateur', 'enseignant'];
        return in_array($userRole, $roles)
        ? Response::allow()
        : Response::deny('Vous n\'avez pas la permission de supprimer cette réservation.');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reservation $reservation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reservation $reservation): bool
    {
        return false;
    }
}
