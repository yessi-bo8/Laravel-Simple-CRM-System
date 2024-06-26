<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Every logged in user can see the tasks retrieved by the Task scope
     */
    public function index(User $user): bool
    {
        return auth()->check();
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
    public function show(User $user, Task $task): bool
    {
        if ($user->roles()->whereIn('role_id', [Role::IS_ADMIN, Role::IS_MOD])->exists()) {
            return true;
        }

        if ($task->user_id == $user->id) {
            return true;
        }

        // Check if the project of the task is associated with a task belonging to the user
        if ($user->tasks()->where('project_id', $task->project_id)->exists()) {
            return true; // User can view tasks related to their projects
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->roles()->whereIn('role_id', [Role::IS_ADMIN, Role::IS_MOD])->exists()
        || $task->user()->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function destroy(User $user): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }
}
