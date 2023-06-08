<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'following_id',
        'followed_id',
        'user_id',
    ];

    public function following()
    {
        return $this->belongsTo(User::class, 'following_id');
    }

    public function followed()
    {
        return $this->belongsTo(User::class, 'followed_id');
    }
}
