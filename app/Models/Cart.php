<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';

    public function users()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}