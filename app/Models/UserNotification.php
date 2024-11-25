<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_user_id', // Changed from admin_id to admin_user_id
        'notification_type',
        'notification_data',
        'is_read',
    ];
}
