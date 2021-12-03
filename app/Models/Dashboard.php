<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    public function orders()
    {
        return $this->hasMany(Orders::class, 'seller_id');
    }
}
