<?php

namespace App\Http\Resources;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RealTaskResource extends JsonResource
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
            'status' => TaskStatusResource::make($this->status),
            'labels' => $this->labels()->get(),
            'created_by' => User::find($this->created_by_id)->name,
            'assigned_to' => User::find($this->assigned_to_id)->name,
            'created_date' => $this->created_at->format('d.m.Y'),
        ];
    }
}
