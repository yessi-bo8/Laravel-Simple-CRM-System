<?php

namespace App\Services;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Exceptions\NotFound\UserNotFoundException;
use App\Exceptions\NotFound\ClientNotFoundException;
use App\Exceptions\NotFound\ProjectNotFoundException;
use App\Exceptions\NotFound\TaskNotFoundException;
use App\Models\Task;
use Dotenv\Exception\ValidationException;

class TaskService
{
    public function updateTask(Task $task, array $validatedData)
    {
        $requiredFields = ['name', 'description', 'due_date', 'project_id', 'user_id', 'status', 'client_id', 'priority'];

        // Check if any required field has changed
        foreach ($requiredFields as $field) {
            $originalValue = $task->{$field};
            $validatedValue = $validatedData[$field];

            if ($validatedValue != $originalValue) {
                $task->update($validatedData);
                return $task;
            }
        }
        throw new TaskNotFoundException("Change something please before updating");
    }
}
