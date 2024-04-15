<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Load the roles relationship
        $this->load('roles');

        // Get an array of role names
        $roleNames = $this->roles->pluck('name')->toArray();

        return [
            'id' => (string)$this->id,
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at,
                'updated_up' => $this->updated_at,
            ],
            'relationships' => [
                'role_name' => $roleNames,
            ]
        ];
    }
}
