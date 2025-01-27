<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VoterDesignation;
use Illuminate\Auth\Access\Response;

class VoterDesignationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VoterDesignation $voterDesignation): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }

    /**
     * Determine whether the user can create models.
     */
    public function createVoterDesignation(User $user): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateVoterDesignation(User $user, VoterDesignation $voterDesignation): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteVoterDesignation(User $user, VoterDesignation $voterDesignation): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }
}
