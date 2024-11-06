<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminId extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'is_assigned',
        'user_id', // Added this line Nov 6 2024
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_assigned' => 'boolean',
    ];
    
    public function users()
    {
        return $this->hasMany(User::class, 'admin_id_registered', 'admin_id');
    }
}
