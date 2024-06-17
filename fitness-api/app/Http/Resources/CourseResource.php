<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            'thumbnail' => $this->thumbnail,
            'videos' => $this->assignment,
            'trainer_name' => $this->user->name,
            'is_published' => $this->is_published
        ];
    }
}

