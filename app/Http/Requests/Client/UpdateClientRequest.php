<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            "name" => ['required', 'string', 'max:50'],
            "email" => ['required', 'string', 'max:100'],
            "company" => ['required', 'string', 'max:100'],
            "vat" => ['required', 'string', 'max:20'],
            "address" => ['required', 'string', 'max:100'],
        ];
    }
}
