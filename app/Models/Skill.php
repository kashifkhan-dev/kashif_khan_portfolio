<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
        'category',
        'proficiency',
        'icon',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'proficiency' => 'integer',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];
}
