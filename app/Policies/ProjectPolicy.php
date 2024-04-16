<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function index(User $user): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists() || $user->projects()->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, Project $project): bool
    {
        return $project->user()->is($user) || $user->roles()->where('role_id', Role::IS_ADMIN)->exists();;
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
    public function update(User $user, Project $project): bool
    {
        return $project->user()->is($user) || $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

}
