<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClearanceRequirement;
use App\Models\User;

class ClearanceFeedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'requirement_id',
        'user_id',
        'message',
        'signature_status',
    ];

    public function requirement()
    {
        return $this->belongsTo(ClearanceRequirement::class, 'requirement_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
