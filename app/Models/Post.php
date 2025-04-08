<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    protected $casts = [
        'title' => 'string',
        'content' => 'string',
        'user_id' => 'integer'
    ];
}
