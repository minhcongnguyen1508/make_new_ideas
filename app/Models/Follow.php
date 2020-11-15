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
        return $this->belongsToMany(self::class, 'followers', 'writer_id', 'user_id')
                    ->withTimestamps();
    }
    public function writer()
    {
        return $this->belongsToMany(self::class, 'followers', 'user_id', 'writer_id')
                    ->withTimestamps();
    }
}
