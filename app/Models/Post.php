<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'slug',
        'content',
        'admin_id',
        'status',
        'thumbnail',
    ];

    const STATUS = [
        0 => 'waiting',
        1 => 'rejected',
        2 => 'commented',
        3 => 'accepted',
    ];

    protected static function booted()
    {
        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where('status', config('company.post_status.accepted'));
        });
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'tag_post',
            'post_id',
            'tag_id'
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likedUsers()
    {
        return $this->belongsToMany(
            User::class,
            'likes',
            'post_id',
            'user_id'
        );
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function reading_list()
    {
        return $this->hasMany(ReadingList::class);
    }
}
