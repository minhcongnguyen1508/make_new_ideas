<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
    protected $fillable = [
        'user_id',
        'comment_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Post::class);
    }
}
