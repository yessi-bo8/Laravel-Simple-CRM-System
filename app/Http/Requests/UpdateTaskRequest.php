<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'client_name' => 'sometimes|string',
            'project_title' => 'sometimes|string',
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
            $originalData = $this->request->all();
            $validatedData = $this->validated();

            // Check if any field has been modified
            $isModified = false;
            foreach ($validatedData as $key => $value) {
                if ($value !== $originalData[$key]) {
                    $isModified = true;
                    break;
                }
            }

            // If no field has been modified, add an error
            if (!$isModified) {
                $validator->errors()->add('no_changes', 'No changes were made to the task.');
            }
        });
    }
}
