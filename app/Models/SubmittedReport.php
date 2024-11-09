<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id', // Added column on Oct 29, 2024
        'title',
        'transaction_type',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
