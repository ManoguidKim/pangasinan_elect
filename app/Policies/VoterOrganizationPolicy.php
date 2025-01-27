<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VoterOrganization;

class VoterOrganizationPolicy
{
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
    public function view(User $user, VoterOrganization $voterOrganizations): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }

    /**
     * Determine whether the user can create models.
     */
    public function createVoterOrganization(User $user): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateVoterOrganization(User $user, VoterOrganization $voterOrganizations): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteVoterOrganization(User $user, VoterOrganization $voterOrganizations): bool
    {
        return in_array(trim($user->role), ['Admin', 'Encoder'], true);
    }
}
