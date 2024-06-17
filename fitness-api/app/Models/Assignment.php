<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'title', 'description', 'link_video'];

    /**
     * Get Submission
     */
    public function submission()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Get User
     */
    public function user()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Get Link Video
     */
    public function getLinkVideoAttribute($value)
    {
        return Storage::url("videoCourses/" . $value);
    }
}

