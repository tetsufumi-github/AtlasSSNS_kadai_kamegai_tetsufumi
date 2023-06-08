<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mail', 'password', 'images', 'bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the follows associated with the user.
     */
    public function follows()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function isFollowing($userId)
    {
        return $this->follows()->where('followed_id', $userId)->exists();
    }
}
