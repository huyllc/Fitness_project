<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
            'email' => $this->email,
            'profile' => $this->profile,
            'enrollment' => $this->enrollment,
            'course' => $this->role == 'pt' ? $this->course : [],
            'studentCourses' => $this->studentCourses,
            'user_description' => $this->profile->description,
            'user_birthday' => $this->profile->birthday,
            'user_sex' => $this->profile->sex,
            'user_picture' => $this->profile->picture,
            'pt_total_student' => $this->profile->total_student
        ];
    }
}

