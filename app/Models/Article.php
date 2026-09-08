<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'read_time',
        'tags',
        'is_published',
        'published_at',
        'views_count',
        'order',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'read_time' => 'integer',
        'views_count' => 'integer',
        'order' => 'integer',
    ];
}
