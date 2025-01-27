<?php

namespace App\Policies;

use App\Models\Designation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DesignationPolicy
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
    public function viewDesignation(User $user, Designation $designation): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can create models.
     */
    public function createDesignation(User $user): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateDesignation(User $user, Designation $designation): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteDesignation(User $user, Designation $designation): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restoreDesignation(User $user, Designation $designation): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDeleteDesignation(User $user, Designation $designation): bool
    {
        return $user->role == "Admin";
    }
}
