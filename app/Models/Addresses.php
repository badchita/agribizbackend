<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    protected $table = 'addresses';
    protected $primaryKey ='id';
    protected $fillable = ['id', 'street_building', 'barangay', 'city', 'province', 'user_id', 'status'];
}
