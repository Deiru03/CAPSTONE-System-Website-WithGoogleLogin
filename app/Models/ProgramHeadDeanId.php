<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramHeadDeanId extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'type',
        'is_assigned',
        'user_id',
    ];

    /**
     * Get the user associated with this ID.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
