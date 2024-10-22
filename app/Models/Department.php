<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'profile_picture' // Add line 10/22/2024
    ];

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}