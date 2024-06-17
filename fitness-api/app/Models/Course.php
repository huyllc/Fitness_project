<?php

namespace App\Models;

use App\Http\Resources\AssignmentResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'duration', 'thumbnail', 'is_published'];
    /**
     * Get User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Enrollment
     */
    public function enrollment()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get Review
     */
    public function review()
    {
        return $this->hasMany(CourseReview::class);
    }

    /**
     * Get Assignment
     */
    public function assignment()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get Link Image
     */
    public function getThumbnailAttribute($value)
    {
        return Storage::url("coursesImage/" . $value);
    }
}

