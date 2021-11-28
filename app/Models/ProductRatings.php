<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRatings extends Model
{
    protected $table = 'product_ratings_review';
    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
