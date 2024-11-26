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
        'notification_message',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adminUser()
    {  
        return $this->belongsTo(User::class, 'admin_user_id');
    }
}
