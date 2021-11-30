<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'mobile',
        'user_type',
        'joined_date',
        'username',
        'address_id',
        'isOnline',
        'status',
    ];

    public function addresses()
    {
        return $this->hasMany(Addresses::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Products::class, 'user_id');
    }

    public function notifications_vendor()
    {
        return $this->hasMany(NotificationsVendor::class, 'to_id')->orderBy("created_at", "DESC");
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
