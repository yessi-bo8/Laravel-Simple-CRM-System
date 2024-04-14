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
     * Determine whether the user can view any models.
     */
    public function index(User $user, Task $task): bool
    {
        // Check if the task belongs to the user directly
        $belongsToUser = $task->user->id == $user->id;

        // Retrieve all tasks associated with the authenticated user
        $userTasks = Task::where('user_id', $user->id)->pluck('project_id')->unique();
        // Retrieve the projects associated with the tasks
        $belongsToProject = Project::whereIn('id', $userTasks)->where('id', $task->project_id)->exists();

        return $belongsToUser || $belongsToProject || $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
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
    public function update(User $user, Task $task): bool
    {
        return $task->user()->is($user) || $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->roles()->where('role_id', Role::IS_ADMIN)->exists();
    }
}
