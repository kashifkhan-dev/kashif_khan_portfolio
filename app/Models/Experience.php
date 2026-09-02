<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company',
        'role',
        'period',
        'location',
        'work_type',
        'description',
        'highlights',
        'technologies',
        'type',
        'order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'technologies' => 'array',
        'order' => 'integer',
    ];
}
