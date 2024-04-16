<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'due_date' => 'sometimes|date',
            'client_id' => 'sometimes|string',
            'user_id' => 'sometimes|string',
            'project_id' => 'sometimes|string',
            'status' => 'sometimes|string|in:pending,approved,rejected',
            'priority' => 'sometimes|string|in:low,medium,high',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $task = $this->route('task');
            $input = $validator->getData();

            $hasChanges = collect([
                'name' => $input['name'] !== optional($task)->name,
                'description' => $input['description'] !== optional($task)->description,
                'due_date' => $input['due_date'] !== optional($task)->due_date,
                'status' => $input['status'] !== optional($task)->status,
                'priority' => $input['priority'] !== optional($task)->priority,
                'client_id' => $input['client_id'] !== optional($task)->client->id,
                'project_id' => $input['project_id'] !== optional($task)->project->id,
            ])->values()->contains(function ($value) {
                return $value;
            });

            if (!$hasChanges) {
                $validator->errors()->add('no_changes', 'No changes have been made to the task.');
            }
        });
    }
}
