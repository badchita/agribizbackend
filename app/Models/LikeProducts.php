<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeProducts extends Model
{
    protected $table = 'like_products';
    protected $primaryKey ='id';
    protected $fillable = ['id', 'product_id', 'user_id', 'status'];
}