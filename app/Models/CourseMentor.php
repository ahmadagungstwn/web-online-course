<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseMentor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'about',
        'is_active',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
