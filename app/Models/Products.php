<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';
    protected $primaryKey ='id';
    protected $fillable = ['id', 'name', 'description', 'price', 'category', 'quantity', 'product_status', 'product_location', 'product_location_id', 'thumbnail_name', 'user_id', 'status'];

    public function addresses()
    {
        return $this->hasMany(Addresses::class, 'id');
    }
}