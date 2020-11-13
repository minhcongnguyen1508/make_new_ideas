<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'user_id',
        'writer_id'
    ];
    public function follower()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id', 'id');
    }
}
