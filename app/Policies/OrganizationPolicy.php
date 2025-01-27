<?php

namespace App\Policies;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrganizationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAnyOrganization(User $user): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can view the model.
     */
    public function viewOrganization(User $user, Organization $organization): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can create models.
     */
    public function createOrganization(User $user): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateOrganization(User $user, Organization $organization): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteOrganization(User $user, Organization $organization): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreOrganization(User $user, Organization $organization): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteOrganization(User $user, Organization $organization): bool
    {
        return $user->role == "Admin";
    }
}
