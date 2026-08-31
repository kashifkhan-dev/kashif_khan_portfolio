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
        'description',
        'highlights',
        'type',
        'order',
    ];

    protected $casts = [
        'highlights' => 'array',
        'order' => 'integer',
    ];
}
