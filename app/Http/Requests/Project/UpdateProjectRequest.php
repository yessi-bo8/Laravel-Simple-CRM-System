<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            "title" => ['required', 'string', 'max:250'],
            "description" => ['required'],
            'event_date' => 'required|date',
            'client_id' => 'required|integer',
            'user_id' => 'required|integer',
            'status' => 'required|string|in:pending,approved,rejected'
        ];
    }
}
