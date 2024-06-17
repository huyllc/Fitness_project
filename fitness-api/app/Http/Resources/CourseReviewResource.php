<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'duration' => $this->duration,
            'thumbnail' => $this->thumbnail,
            'trainer_id' => $this->user->id,
            'trainer_name' => $this->user->name,
            'enrollments' => count($this->enrollment)
        ];
    }
}

