<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Document;
use App\Models\Role;
use App\Models\Receipt;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['role_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function downloads()
    {
        return $this->belongsToMany(Document::class, 'downloads')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(Document::class, 'favorites')->withTimestamps();
    }

    public function comments()
    {
        return $this->belongsToMany(Document::class, 'comments')->withPivot('content')->withTimestamps();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'follower_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'user_id')->withTimestamps();
    }

    public function sendMessages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public function receiveMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
