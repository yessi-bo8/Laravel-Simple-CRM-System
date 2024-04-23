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
                'user_id' => (string)$this->user->id,
                'user_name' => $this->user->name,
                'user_email' => $this->user->email,
                'id_client'=> (string)$this->client->id,
                'client_name' => $this->client->name,
                'role_names' => $this->user->roles->pluck('name')->toArray(),
            ]
        ];
 
    }
}
