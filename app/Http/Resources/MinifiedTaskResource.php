<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MinifiedTaskResource extends JsonResource
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
            'description' => $this->makeShort($this->description, 40),
            'status_id' => $this->status_id,
            'created_date' => $this->created_at->format('d.m.Y'),
        ];
    }

    public function makeShort(?string $text, int $limit = 35): string
    {
        if ($text === null) {
            return '';
        }

        if (mb_strlen($text) < $limit) {
            return $text;
        }

        return mb_substr($text, 0, $limit) . '...';
    }
}
