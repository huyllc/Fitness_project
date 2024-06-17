<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'rating',
        'total_student',
        'sex',
        'birthday',
        'picture',
    ];

    /**
     * Get User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get Url image
     */
    public function getPictureAttribute($value)
    {
        return Storage::url("profileImage/" . $value);
    }
}

