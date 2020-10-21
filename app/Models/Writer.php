<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Writer extends Model
{
    protected $fillable = [
        'phone',
        'description',
        'admin_id',
        'user_id',
        'salary',
        'cv_path',
        'status'
    ];

    const STATUS = [
        0 => 'rejected',
        1 => 'accepted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
