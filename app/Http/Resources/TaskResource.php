<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
                'priority' => $this->priority,
                'due_date' => $this->due_date,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'user' => [
                    'id' => (string)$this->user_id,
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                ],
                'project' => [
                    'id' => (string)$this->project_id,
                    'title' => $this->project->title,
                ],
                'client' => [
                    'id' => (string)$this->client_id,
                    'name' => $this->client->name,
                ]
            ]
        ];
    }
}
