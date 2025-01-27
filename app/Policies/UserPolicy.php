<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
    public function view(User $user, User $model): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can create models.
     */
    public function createUser(User $user): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateUser(User $user, User $model): bool
    {
        return $user->role == "Admin";
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function deleteUser(User $user, User $model): bool
    {
        return $user->role == "Admin";
    }
}
