<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'profile_picture' => 'image|max:2048|dimensions:min_width=100,min_height=100',
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'max:100', 'unique:clients'],
            'company' => ['required', 'string', 'max:100', 'unique:clients'],
            'vat' => ['required', 'string', 'max:20', 'unique:clients'],
            'address' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages()
    {
        return [
            'profile_picture.image' => 'The file must be an image.',
            'profile_picture.max' => 'The file size must not exceed 2MB.',
            'profile_picture.dimensions' => 'The image dimensions must be at least 100x100 pixels.',
        ];
    }
}
