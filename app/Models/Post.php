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

    protected function casts(): array
    {
        return [
            'title' => 'string',
            'content' => 'string',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
