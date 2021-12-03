<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    public function dashboard()
    {
        return $this->belongsTo(Dashboard::class, 'user_id');
    }
}
