<?php

namespace App\Policies;

use App\Models\User;
use App\Models\offer;
use Illuminate\Auth\Access\Response;

class OfferPolicy
{
    public function before(User $user, $ability)
    {
        if ($user->role->name === 'admin') {
            return true;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, offer $offer): bool
    {
        return $user->id === $offer->user_id;
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role->name === 'recruteur';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, offer $offer): bool
    {
        return $user->id === $offer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, offer $offer): bool
    {
        return $user->id === $offer->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, offer $offer): bool
    {
        return $user->id === $offer->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, offer $offer): bool
    {
        return $user->id === $offer->user_id;
    }
}
