<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreTaskRequest extends FormRequest
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
            "name" => ['required', 'string', 'max:250'],
            "description" => ['required'],
            'due_date' => 'required|date',
            'client_id' => 'required|string',
            'user_id' => 'required|string',
            'project_id' => 'required|string',
            'status' => 'required|string|in:pending,approved,rejected',
            'priority' => 'required|string|in:low,medium,high',
        ];
    }


}
