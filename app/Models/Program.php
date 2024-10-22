<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'department_id',
        'profile_picture' // Add line 10/22/2024
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
