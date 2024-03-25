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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status_id' => $this->status_id,
            'labels' => $this->labels()->get(),
            'created_by_id' => $this->created_by_id,
            'assigned_to_id' => $this->assigned_to_id,
            'created_date' => $this->created_at->format('d.m.Y'),
        ];
    }
}
