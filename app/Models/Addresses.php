<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    protected $table = 'addresses';
    protected $primaryKey ='id';
    protected $fillable = ['id', 'street_building', 'barangay', 'city', 'province', 'user_id', 'status'];

    public function products()
    {
        return $this->belongsTo(Products::class, 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}