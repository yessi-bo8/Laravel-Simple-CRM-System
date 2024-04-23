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
            'client_id' => 'required|integer',
            'user_id' => 'required|integer',
            'project_id' => 'required|integer',
            'status' => 'required|string|in:pending,in progress,completed',
            'priority' => 'required|string|in:low,medium,high',
        ];
    }


}
