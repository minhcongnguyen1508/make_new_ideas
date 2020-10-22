<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;

    const ROLE_USER = 1;

    protected $fillable = [
        'username',
        'email',
        'password',
        'provider',
        'provider_id',
        'role_id'
    ];

    protected $attributes = [
        'role_id' => self::ROLE_USER,
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function writerRequest()
    {
        return $this->hasOne(Writer::class);
    }

    public function writerConfirm()
    {
        return $this->hasMany(Writer::class, 'admin_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
