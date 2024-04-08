<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
                'email' => $this->email,
                'company' => $this->company,
                'vat' => $this->vat,
                'address' => $this->address,
                'created_at' => $this->created_at,
                'updated_up' => $this->updated_at,
            ],
            'relationships' => [
                'project' => $this->projects->pluck('id')->toArray(),
                'project titles' => $this->projects->pluck('title')->toArray(),
            ]
        ];
    }
}
