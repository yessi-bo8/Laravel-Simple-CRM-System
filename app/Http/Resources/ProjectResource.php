<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Get the user's roles
        $roles = $this->user->roles;

        // Get the first role ID from the collection of roles
        $roleName = $roles->isNotEmpty() ? (string) $roles->first()->name : null;

        return [
            'id' => (string)$this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'event_date' => $this->event_date,
                'created_at' => $this->created_at,
                'updated_up' => $this->updated_at,
            ],
            'relationships' => [
                'id' => (string)$this->user->id,
                'user name' => $this->user->name,
                'user email' => $this->user->email,
                'id_client'=> (string)$this->client->id,
                'role_name' => (string)$roleName,
            ]
        ];
 
    }
}
