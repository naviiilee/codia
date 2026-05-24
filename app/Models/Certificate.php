<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'username',
        'first',
        'last',
        'course_name',
        'score',
        'percentage',
        'passed',
        'awarded_at',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'awarded_at' => 'datetime',
    ];
}
