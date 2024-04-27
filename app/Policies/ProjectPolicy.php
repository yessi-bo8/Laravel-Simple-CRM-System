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
        return $user->roles()->whereIn('role_id', [Role::IS_ADMIN, Role::IS_MOD])->exists()
        || $user->projects()->exists();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, Project $project): bool
    {
        if ($user->roles()->whereIn('role_id', [Role::IS_ADMIN, Role::IS_MOD])->exists()) {
            return true;
        }
        
        return $project->user()->is($user) // User is directly associated with the project
            || $project->tasks()->where('user_id', $user->id)->exists(); // User is assigned tasks for the project
    }

    /**
     * Determine whether the user can create models.
     */
    public function store(User $user): bool
    {
        return $user->roles()->whereIn('role_id', [Role::IS_ADMIN, Role::IS_MOD])->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): bool
    {
        return $user->roles()->whereIn('role_id', [Role::IS_ADMIN, Role::IS_MOD])->exists()
        || $project->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user, Project $project): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

}
