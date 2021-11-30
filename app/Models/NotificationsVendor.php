<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsVendor extends Model
{
    protected $table = 'notifications_vendor';

    public function users()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
}