<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, Client $client): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Client $client): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

}
